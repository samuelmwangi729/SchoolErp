/*global ga, tmntag, requirejs */
/*jshint loopfunc: true */
var JWPLAYER_VERSION = "1.0.4";
(function() {
  "use strict";
  function isMacro(text) {
    return text.indexOf('${') >= 0;
  }

  function defaultValue(str, defaultValue) {
    return isMacro(str) ? defaultValue : str;
  }

  function memoize(func) {
    var memo = {};

    return function() {
      var args = Array.prototype.slice.call(arguments);

      if (!(args in memo)) {
        memo[args] = func.apply(this, args);
      }
      return memo[args];
    }
  }

  function gaSend() {
    var args = arguments;
    if (window.ga) {
      window.ga(function(tracker) {
        if (tracker) {
          tracker.send.apply(tracker, args);
        } else {
          window.ga.getAll().forEach(function(tracker) {
            tracker.send.apply(tracker, args);
          })
        }
      });
    }
  }

  // jwplayer
  var Jwplayer = function(o) {
    o.init = o.init || true;
    o.settings = o.settings && defaultValue(o.settings, '{}');
    try {
      o.settings = JSON.parse(o.settings);
    } catch (e) {
      o.settings = {};
    }

    this.playlistTarget = defaultValue(o.playlistTarget, '.null');
    this.playlistTargetHandler = defaultValue(o.playlistTargetHandler, 'afterend');
    this.playerLicenseKey = defaultValue(o.playerLicenseKey, 'NLVTwYKe5kBs2O1ZEZFGvVo1Y44MJtPAymTh/PhEGb7r7GUh');
    this.playlistId = defaultValue(o.playlistId, 'VDpm3tMH');
    this.rightRail = defaultValue(o.rightRail, '.page-content-rightcol');
    this.container = defaultValue(o.container, '.null');
    this.recommendationsURL = defaultValue(o.recommendationsURL, '');
    this.rightRailEl = document.querySelector(this.rightRail);
    this.containerEl = document.querySelector(this.container);
    this.playerSrc =  defaultValue(o.playerSrc, 'https://assets.purch.com/ramp/assets/jwplayer/jwplayer-8.2.3-self-hosted.js');
    this.playlistSrc = 'https://content.jwplatform.com/feeds/' + this.playlistId + '.json';
    this.scriptsLoaded = [];
    this.gaInited = false;
    this.gaAccount = o.gaAccount;
    this.playerContainers = {};
    this.autoplay = o.forceAutoPlay && !isMacro(o.forceAutoPlay) ? o.forceAutoPlay === 'true' : o.device.toLowerCase() !== 'mobile';
    this.customStyles = defaultValue(o.customStyles, '.jw-loaded { background-color: rgba(0,0,0,.1); margin: 5px 0; }');
    this.useNativeDocking = o.useNativeDocking && defaultValue(o.useNativeDocking, 'false') === 'true';
    this.device = o.device.toLowerCase();
    this.randomizePlaylist = o.randomizePlaylist && defaultValue(o.randomizePlaylist, 'false') === 'true';
    this.isMobile = o.device.toLowerCase() === 'mobile';
    this.floatingButton = o.floatingButton && defaultValue(o.floatingButton, 'false') === 'true';
    this.floatingButtonMode = o.floatingButtonMode && defaultValue(o.floatingButtonMode, 'sticky');
    this.floatingButtonTopOffset = o.floatingButtonTopOffset && defaultValue(o.floatingButtonTopOffset, 10);
    this.adunitAccount = defaultValue(o.adunitAccount || '${', false);
    this.mobileVerticalDockingPosition = o.mobileVerticalDockingPosition && defaultValue(o.mobileVerticalDockingPosition, "top");
    this.mobileHorizontalDockingPosition = o.mobileHorizontalDockingPosition && defaultValue(o.mobileHorizontalDockingPosition, false);
    this.useAdScheduling = o.useAdScheduling && defaultValue(o.useAdScheduling, 'false') === 'true';
    this.showCloseButton = o.showCloseButton && defaultValue(o.showCloseButton, 'false') === 'true';

    var bids = isMacro(o.bidderID) ? null : {
      bids: {
        settings: {
          mediationLayerAdServer: "dfp",
        },
        bidders: [
          {
            name: "SpotX",
            id: o.bidderID,
            optionalParams: { ad_volume: Number(o.device.toLowerCase() === 'mobile') }
          }
        ]
      }
    };

    var advertising = Object.assign({
      client: 'googima'
    }, bids);

    if (this.useAdScheduling) {
      advertising.preloadAds = true;
      advertising.schedule = [{
        offset: 'pre',
        tag: window.tmntag.video.getVMAPEndpoint ? window.tmntag.video.getVMAPEndpoint(this.adunitAccount) : '',
        type: 'linear'
      }];
      advertising.autoplayadsmuted = true;
      advertising.vpaidcontrols = true;
      advertising.creativeTimeout = 20000;
      advertising.requestTimeout = 20000;
      advertising.loadVideoTimeout = 20000;
      advertising.adsRequestTimeout = 20000;
      advertising.requestTimeout = 20000;
      advertising.maxRedirects = 6;
    }

    this.settings = {
      advertising: advertising,
      ga: {
        idstring: 'gtm21'
      },
      controls: true,
      width: '100%',
      stretching: 'uniform',
      aspectratio: '16:9',
      primary: 'html5',
      related: {
        file: this.recommendationsURL,
        autoplaytimer: 0,
        onclick: "play",
        oncomplete: "autoplay"
      },
      localization: {
        related: 'Your Recommended Playlist'
      },
      mute: true,
      autostart: false,
      sharing: {
        link: document.location.href,
        sites: [
          'facebook',
          'twitter',
          'email',
          'reddit'
        ]
      },
      key: this.playerLicenseKey
    };

    for (var s in o.settings) {
      if (o.settings.hasOwnProperty(s)) {
        this.settings[s] = o.settings[s];
      }
    }

    var self = this;
    // DES-640 - JWP - Video on Slideshows
    [].slice.call(document.querySelectorAll('.carousel-loadable')).forEach(function(carousel) {
      carousel.addEventListener('carousel-loadable-complete', self.init.bind(self));
    }, this);

    if (o.init === true) {
      this.init();
    }
  };

  Jwplayer.prototype = {
    init: function() {
      window.onbeforeunload = function() {
          if(sessionStorage.jwDisableDocking){
            sessionStorage.removeItem('jwDisableDocking');
          }
          return undefined;
      };
      this.addStyles();
      if (this.useNativeDocking) {
        this.initNativeDocking()
      }

      var players = this.getPlayers();
      if (!players.length) {
        if (window.Purch && window.Purch.JwShowPlaylist === true) {
          return this.renderPlaylist();
        }
      }

      this.addScript(this.playerSrc, this.initPlayers.bind(this, players));
    },
    version: function() {
    	return JWPLAYER_VERSION;
    },
    clientDim: function() {
      try {
        var w = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        var h = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
        return {width: w, height: h};
      } catch (e) {
        console.error(e);
      }
      return {width: 0, height: 0};
    },
    getLeftAndWidth: function() {
      var clientDim = this.clientDim();
      var rightRail = this.rightRailEl && this.rightRailEl.getBoundingClientRect();
      var container = this.containerEl && this.containerEl.getBoundingClientRect();
      var hasRightRail = rightRail && rightRail.right;
      // we have right rail and it's not hidden
      var width = hasRightRail ? rightRail.width : 300;
      width = (this.isMobile)?247:width;

      // we have to return two positions
      // to stick on the bottom left (listings)  and bottom right (contents)
      var bottomRight = (hasRightRail ? rightRail.right : container.right) - width;
      bottomRight = (this.isMobile)?(clientDim.width-width)/2:bottomRight;
      var bottomLeft = container.left;

      return {
        bottomRight: bottomRight,
        bottomLeft: bottomLeft,
        width: width
      };
    },
    getMinimizedPositions: function(dimensions) {
      var distance = dimensions.bottomRight;

      if (this.isMobile && this.mobileHorizontalDockingPosition) {
        if (this.mobileHorizontalDockingPosition.toLowerCase() === "right") {
          distance = dimensions.bottomRight*2;
        } else {
          distance = 0;
        }
      }

      return [
        // by default, stick on the middle
        '.jw-player-minimize .jw-player-position {',
          'left:' + distance + 'px;',
        '}',
        // listing pages
        '.listing .jw-player-minimize .jw-player-position,',
        '.listing-page .jw-player-minimize .jw-player-position {',
          'left:' + dimensions.bottomLeft + 'px;',
        '}'
      ].join('')
    },
    getVerticalDockingPosition: function(dimensions) {
      if (this.isMobile) {
        if (this.mobileVerticalDockingPosition.toLowerCase() === "bottom") {
          return { bottom: 'bottom:115px;', top: '', width:'width:'+ dimensions.width + 'px;' };
        }
        return { bottom: '', top: 'top:60px;', width:'width:' + dimensions.width + 'px;' };
      }
      return { bottom: 'bottom:0;', top: '', width:'width:' + dimensions.width + 'px;'};
    },
    addStyles: function() {
      var dimensions = this.getLeftAndWidth();
      var position = this.getVerticalDockingPosition(dimensions);
      var styles = [
        this.customStyles,
        '.jw-dock-image { background-size:45%; }',
        '.jw-dock-button[button="close"] { display:none; }',
        '@media screen and (min-width: 250px) {',
          '@keyframes jw-minimize {',
            '0%   { opacity: 0; }',
            '100% { opacity: 1; }',
          '}',
          '.jw-player-minimize { animation: jw-minimize .6s; }',
          '.jw-player-minimize .jw-dock-button[button="close"] { display:inherit; }',
          '.jw-player-minimize .jw-flag-small-player .jw-dock-button { width:30px;height:30px; }',
          '.jw-player-minimize .jw-player-position {',
            'transition: top .2s, transform .2s;',
            'position: fixed; z-index:9999; '+position.width+position.top+position.bottom,
          '}',
          this.getMinimizedPositions(dimensions),
        '}',
        'a.ftr-close-button { border: none; cursor: pointer; position: absolute; top: 10px; right: 10px; z-index: 100; width: 25px; height: 25px; }',
        '.ftr-close-button path { fill: white; }',
        '.ftr-close-button:hover path { fill: #eee; }'
      ].join('');
      var s = document.createElement('style');
      s.id = 'jw-main-styles';
      this.resizeStyles = document.createElement('style');
      this.resizeStyles.id = 'jw-resize-styles';
      this.stickyStyles = document.createElement('style');
      this.stickyStyles.id = 'jw-sticky-styles';
      this.offsetBottomStyles = document.createElement('style');
      this.offsetBottomStyles.id = 'jw-offset-bottom-styles';
      s.innerHTML = styles;
      document.head.appendChild(s);
      document.head.appendChild(this.resizeStyles);
      document.head.appendChild(this.stickyStyles);
      document.head.appendChild(this.offsetBottomStyles);
    },
    addScript: function(src, cb) {
      cb = cb || function() {};
      var self = this;
      if (this.scriptsLoaded.indexOf(src) >= 0) {
        return cb();
      }

      if (window.require && window.requirejs){
        requirejs.config({"paths":{"jwPlatformLib":src.replace('.js','')}});
        require(["jwPlatformLib"],function(jwPlatformLib){
          self.scriptsLoaded.push(src);
          cb();
        });
        return;
      } else {
        var s = document.createElement('script');
        s.src = src;
        s.onload = function() {
          self.scriptsLoaded.push(src);
          cb();
        };
        document.head.appendChild(s);
      }
    },
    getSettings: function() {
      // get a copy of the settings so it's always clean
      return JSON.parse(JSON.stringify(this.settings));
    },
    renderPlaylist: function() {
      var target;
      try {
        target = document.querySelector(this.playlistTarget);
      } catch (e) { console.log(e); }
      if (!target) {
        return;
      }
      var divId = 'jw-' + (new Date()).getTime();
      var settings = this.getSettings();

      settings.playlist = this.playlistSrc;
      settings.isPlaylist = true;
      var minHeight=(this.isMobile)?"210px":"320px";
      target.insertAdjacentHTML(this.playlistTargetHandler, '<div style="min-height:'+minHeight+'"><div jw-playlist-auto class="jw-loaded">' + this.getTemplate(divId) + '</div></div>');
      return this.addScript(
          this.playerSrc,
          this.renderPlayer.bind(this, divId, settings, document.querySelector('[jw-playlist-auto]'), 0)
      );
    },
    getTemplate: function(divId) {
      return [
        '<div id="' + divId + '-position" class="jw-player-position">',
          '<div id="' + divId + '"></div>',
        '</div>'
      ].join('');
    },
    refresh: function(context) {
      var players = this.getPlayers(context);
      if (!players.length) {
        return;
      }
      this.addScript(this.playerSrc, this.initPlayers.bind(this, players));
    },
    getPlayers: function(context) {
      return [].slice.call((context || document.body).querySelectorAll('[data-jwplayer-id]:not(.jw-loaded)'));

    },
    initPlayers: function(players) {
      for (var j = 0; j < players.length; j++) {
        var divId = 'jw-' + (new Date()).getTime();
        var mediaId = players[j].getAttribute('data-jwplayer-id');
        players[j].innerHTML = this.getTemplate(divId);
        players[j].className = players[j].className + ' jw-loaded';
        var settings = this.getSettings();
        if (j > 0) {
          settings.autostart = false;
        }

        if (mediaId.indexOf('-') >= 0) {
          settings.playlist = 'https://content.jwplatform.com/feeds/' + mediaId.split('-')[1] + '.json';
          settings.isPlaylist = true;
        } else {
            // reorder the tracklist, put current media first
          settings.playlist = 'https://content.jwplatform.com/v2/media/' + mediaId;
        }
        this.renderPlayer(divId, settings, players[j], j);
      }
    },
    initTracking: function(instance, settings) {
      if (!window.ga) {
        return;
      }
      if (!this.gaInited) {
        ga('create', this.gaAccount, 'auto');
        this.gaInited = true;
      }

      var getGACookie = memoize(function() {
        var gaCookiePair = document.cookie.split('; ')
        .map(function(cookie) { return cookie.split('='); })
        .find(function(pair) { return pair[0] === '_ga'; });

        if (gaCookiePair.length > 0) {
          return gaCookiePair[1];
        }

        return null;
      })

      function getDimensions(instance, nonInteraction, settings) {
        return Object.assign(
          {
            nonInteraction: nonInteraction,
            dimension106: document.querySelectorAll('.jwplayer').length,
            dimension59: getGACookie(),
            dimension107: instance.getPlaylistItem().duration,
            dimension108: instance.getVisualQuality().level.height,
            dimension113: settings.isPlaylist ? true : false
          },
          window.analytics_ga_data || {}
        )
      }

      instance.on('play', function(playInfo) {
        gaSend('event', 'jwplayer', 'play', instance.getPlaylistItem().mediaid, getDimensions(instance, playInfo.playReason === 'autostart', settings));
      });

      instance.on('pause', function() {
        gaSend('event', 'jwplayer', 'pause', instance.getPlaylistItem().mediaid, getDimensions(instance, true, settings));
      });

      instance.on('seek', function() {
        gaSend('event', 'jwplayer', 'seek', instance.getPlaylistItem().mediaid, getDimensions(instance, true, settings));
      });

      instance.on('complete', function() {
        gaSend('event', 'jwplayer', 'complete', instance.getPlaylistItem().mediaid, getDimensions(instance, false, settings));
      });

      instance.on('adImpression', function() {
        gaSend('event', 'jwplayer', 'adplay', instance.getPlaylistItem().mediaid, getDimensions(instance, true, settings));
      });

      instance.on('adComplete', function() {
        gaSend('event', 'jwplayer', 'adcomplete', instance.getPlaylistItem().mediaid, getDimensions(instance, true, settings));
      });

      instance.on('adSkipped', function() {
        gaSend('event', 'jwplayer', 'adskip', instance.getPlaylistItem().mediaid, getDimensions(instance, true, settings));
      });

      instance.on('setupError', function() {
        gaSend('event', 'jwplayer', 'playererror', instance.getPlaylistItem().mediaid, getDimensions(instance, true, settings));
      });

      instance.on('levelsChanged', function(newQuality) {
        var dimensions = getDimensions(instance, true, settings)

        if (newQuality.currentQuality !== 0) {
          dimensions.dimension108 = String(newQuality.levels[newQuality.currentQuality].height);
        }

        gaSend('event', 'jwplayer', 'qualitychange', instance.getPlaylistItem().mediaid, dimensions)
      })

      if (instance.getViewable() === 1) {
        gaSend('event', 'jwplayer', 'viewable', instance.getPlaylistItem().mediaid, getDimensions(instance, true, settings))
      }
    },

    initSticky: function() {
      if (this.floatingButton) {
        return;
      }

      // sticky was already init
      if (typeof this.isScrollTimeout !== 'undefined') {
        return;
      }
      var self = this;
      this.isScrollTimeout = null;
      this.isResizeTimeout = null;
      this.lastSticky = null;
      document.addEventListener('scroll', function() {
        self.isScrollTimeout = self.scrollHandler();
      });
      window.addEventListener('resize', function() {
        self.isResizeTimeout = self.resizeHandler();
      });
    },
    scrollHandler: function() {
      clearTimeout(this.isScrollTimeout);
      return setTimeout(this.onScrollViewHandler.bind(this), 40);
    },
    resizeHandler: function() {
      clearTimeout(this.isResizeTimeout);
      return setTimeout(this.onResizeViewHandler.bind(this), 40);
    },
    onResizeViewHandler: function() {
      var dimensions = this.getLeftAndWidth();

      this.resizeStyles.innerHTML = [
        '@media screen and (min-width: 668px) {',
          '.jw-player-minimize .jw-player-position {',
            'width:' + dimensions.width + 'px;',
          '}',
          this.getMinimizedPositions(dimensions),
        '}'
      ].join('');

      // resize each players containers
      for (var divId in this.playerContainers) {
        if (this.playerContainers.hasOwnProperty(divId)) {
          var dim = this.playerContainers[divId].el.getBoundingClientRect();
          var playerWidth = dim.width;
          var playerHeight = (playerWidth * 9)/16;
          this.playerContainers[divId].el.style.height = playerHeight + 'px';
        }
      }
    },
    onScrollViewHandler: function() {
      var scrollTop = this.getScrollTop();

      for (var divId in this.playerContainers) {
        if (this.playerContainers.hasOwnProperty(divId)) {
          var instance = this.playerContainers[divId].instance;
          var playerContainerEl = this.playerContainers[divId].el;
          var elementHeight = this.getElementHeight(playerContainerEl);

          var elementOffsetTop = this.getElementOffsetTop(playerContainerEl);
          var offset = elementHeight/(2.5);
          var elementY = elementOffsetTop - this.getWindowHeight();

          var isInView = elementY + offset < scrollTop &&
              elementOffsetTop + elementHeight - offset > scrollTop;

          if (isInView) {
            if (!this.interactiveId) {
              this.interactiveId = divId;
            }

            if (this.interactiveId === divId) {
              this.playerContainers[divId].dockable = true;
              if (
                ['complete', 'paused'].indexOf(instance.getState()) === -1
                && this.autoplay
                && !this.useAdScheduling
                && window.Purch && window.Purch.JwDisableAutoPlay !== true
                && window.tmntag && window.tmntag.video && window.tmntag.video.autostarted
              ) {
                window.tmntag.video.autostarted(divId, true);
              }
            } else {
              this.playerContainers[divId].dockable = false;
            }
          }

          if (this.playerContainers[divId].dockable) {
            if (this.playerContainers[divId].dockable !== isInView) {
              this.dock(this.playerContainers[divId]);
            } else {
              this.undock(this.playerContainers[divId]);
            }
          }
        }
      }
    },
    shouldNotDock: function(container) {
      return this.hasDockCookie()
      		|| this.useNativeDocking
      		|| (window.Purch && window.Purch.JwDisableSticky === true)
      		|| container.instance.getState()==='paused'
      		|| container.instance.getState()==='idle';
    },
    isDocked: function(container) {
      return container.utils.hasClass(container.el, 'jw-player-minimize');
    },
    dock: function(container) {
      if (this.shouldNotDock(container) || this.isDocked(container)) {
        return;
      }
      container.el.style.height = container.instance.getHeight() + 'px';
      container.utils.toggleClass(container.el, 'jw-player-minimize', true);
      if (!this.isMobile) this.checkFooterAdOffset();
      this.resize(container.instance, container.elPosition);
      this.lastSticky = container;
    },
    undock: function(container, pause) {
      if (!this.isDocked(container)) {
        return;
      }
      if (pause) {
        container.instance.pause(true);
      }
      container.utils.toggleClass(container.el, 'jw-player-minimize', false);
      this.resize(container.instance, container.elPosition);
    },
    resize: function(instance, elPosition) {
      // get .jw-player-position sizes
      var dimensions = elPosition.getBoundingClientRect();
      var playerWidth = dimensions.width;
      var playerHeight = (playerWidth * 9)/16;
      instance.resize(playerWidth, playerHeight);
    },
    checkFooterAdOffset: function(){
      var footerElementsSelector = "div[id^='bom_footer'],.wpl-product-sticky.is-active,.purch-anchor-adunit,.prism-modal-content";
      var footerElements = Array.prototype.slice.call(document.querySelectorAll(footerElementsSelector));
      footerElements = footerElements.filter(function(el) { return el.getBoundingClientRect().height > 0; });
      var highestTopLine = Math.min.apply(null, footerElements.map(function(el) { return el.getBoundingClientRect().top; }));
      var offset = Math.max(window.innerHeight - highestTopLine, 0);
      this.offsetBottomStyles.innerHTML = '.jw-player-minimize .jw-player-position { bottom: ' + offset + 'px; }';
    },
    getElementOffsetTop: function(el) {
      var boundingClientRect = el.getBoundingClientRect();
      var bodyEl = document.body;
      var docEl = document.documentElement;
      var scrollTop = window.pageYOffset || docEl.scrollTop || bodyEl.scrollTop;
      var clientTop = docEl.clientTop || bodyEl.clientTop || 0;
      return Math.round(boundingClientRect.top + scrollTop - clientTop);
    },
    getWindowHeight: function () {
      return window.innerHeight || document.documentElement.clientHeight;
    },
    getElementHeight: function(el) {
      var boundingClientRect = el.getBoundingClientRect();
      return boundingClientRect.height;
    },
    getScrollTop: function() {
      var docEl = document.documentElement;
      return (window.pageYOffset || docEl.scrollTop) - (docEl.clientTop || 0);
    },
    setDockCookie: function() {
      // Save data to sessionStorage
      sessionStorage.setItem('jwDisableDocking', '1');
    },
    hasDockCookie: function() {
      return sessionStorage.getItem('jwDisableDocking') === '1';
    },
    onUserInteraction: function(instance) {
      for (var id in this.playerContainers) {
        if (this.playerContainers.hasOwnProperty(id)) {
          if (instance.getContainer().id !== id) {
            this.playerContainers[id].dockable = false;
            this.undock(this.playerContainers[id], true);
          }
        }
      }
      this.interactiveId = instance.getContainer().id;
    },
    renderPlayer: function(divId, settings, playerContainerEl, playerIndex) {
      var self = this;
      var playerInstance = window.jwplayer(divId);
        if (!playerInstance) {
        return;
      }

      if (window.Purch && window.Purch.JwDisableAutoPlay !== true && self.autoplay && playerIndex == 0){
      //If User Device is Desktop And not a Homepage Set Autostart from False to Viewable//
          settings.autostart = 'viewable';
      }

      playerInstance.setup(settings);

      var useAdScheduling = this.useAdScheduling
      if (window.tmntag && tmntag.cmd) {
        tmntag.cmd.push(function(){
          if (!useAdScheduling) {
            try {
              tmntag.video.start(divId, settings, playerInstance, {div:'video_content', account:self.adunitAccount});
            } catch (e) {}
          } else {
            tmntag.video.bindVideoEvents && tmntag.video.bindVideoEvents(playerInstance)
          }
        });
      }

      function addCloseButton() {
        if (self.showCloseButton) {
          var id = playerInstance.getContainer().id + '-close-button';
          if (!document.getElementById(id)) {
            var closeButton = document.createElement('a');
            closeButton.innerHTML = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 426.667 426.667" style="enable-background:new 0 0 426.667 426.667;" xml:space="preserve">' +
              '<path d="M213.333,0C95.514,0,0,95.514,0,213.333s95.514,213.333,213.333,213.333 s213.333-95.514,213.333-213.333S331.153,0,213.333,0z M330.995,276.689l-54.302,54.306l-63.36-63.356l-63.36,63.36l-54.302-54.31 l63.356-63.356l-63.356-63.36l54.302-54.302l63.36,63.356l63.36-63.356l54.302,54.302l-63.356,63.36L330.995,276.689z"></path>' +
            '</svg>';

            closeButton.id = id;
            closeButton.classList.add('ftr-close-button');
            closeButton.addEventListener('click', function closeHandler() {
              if (!self.lastSticky) {
                playerInstance.pause();
                return;
              }
              self.setDockCookie();
              self.undock(self.lastSticky, true);
            })
            playerInstance.getContainer().appendChild(closeButton);
          }
        }
      }
      playerInstance.on('playlistItem', addCloseButton);
      playerInstance.on('adError', addCloseButton);

      if (this.floatingButton) {
        playerInstance.on('ready', function() {
          this.initFloatingButton(playerInstance, settings, {
            device: this.device,
            mode: this.floatingButtonMode,
            topOffset: this.floatingButtonTopOffset,
            playlistSrc: this.playlistSrc
          });
        }.bind(this));
      }

      playerInstance.on('play', function(state) {

        if (state.playReason === 'interaction') {
          self.onUserInteraction(this);
          this.setMute(false);
        }
      });

      playerInstance.on('adPlay', function () {
        self.onUserInteraction(this);
      });

      playerInstance.on('fullscreen', function(state) {
        self.onUserInteraction(this);
        if (state.fullscreen === true) {
          this.setMute(false);
        }
      });

      playerInstance.on('volume', function() {
        self.onUserInteraction(this);
      });

      playerInstance.on('ready', function() {
        var config = this.getConfig();

        if (config.playlist && self.randomizePlaylist) {
          self.randomizeVideosInPlaylist(playerInstance, config.playlist);
        }

        var playerContainer = playerInstance.getContainer();
        var parentTitleDiv = playerContainer.querySelector('.jw-title');

        this.on('pause', function(){
            try {
                if(parentTitleDiv && parentTitleDiv.style.display && this.getState() === 'paused'){
                  parentTitleDiv.style.display = 'block';
                }
            }
            catch(e) {
                return false;
            }
        });

        this.on('play', function(){
            try {
                if(parentTitleDiv && parentTitleDiv.style.display !== 'none' && this.getState() === 'playing'){
                    parentTitleDiv.style.display = 'none';
                }
            }
            catch(e) {
                return false;
            }
        });

        playerContainer.addEventListener('mouseenter', function() {
            if(parentTitleDiv){
                parentTitleDiv.style.display = 'block';
            }
        });

        //Remove title and caption when mouse not on video
        playerContainer.addEventListener('mouseleave', function() {
            if(parentTitleDiv && playerInstance.getState() === 'playing'){
                parentTitleDiv.style.display = 'none';
            }
        });

        var id = this.getContainer().id; // dynamic id (ex: jw-6456464)

        self.playerContainers[id] = {
          el: playerContainerEl, // [data-jwplayer-id]
          elPosition: document.getElementById(id + '-position'),
          instance: this,
          utils: this.utils
        };

        self.onScrollViewHandler();
      });

      this.initTracking(playerInstance, settings);
      this.initSticky();
    },

    initNativeDocking: function() {
      if (this.device === 'mobile') {
        return;
      }

      var possibleCollidingElementsSelectors = ['#mobile-anchor', '#purch_Y_O_1_1'];

      function isOverlapping(e1, e2){
        var rect1 = e1 instanceof Element ? e1.getBoundingClientRect() : false;
        var rect2 = e2 instanceof Element ? e2.getBoundingClientRect() : false;

        if(rect1 && rect2){
          return !(rect1.bottom < rect2.top || rect1.top > rect2.bottom);
        }
      }

      function curry(f) { return function(a) { return function(b) { return f(a, b); }; }; };
      function isVisible(element) { return window.getComputedStyle(element).display !== 'none'; }
      function getHeight(element) { return element.getBoundingClientRect().height; }

      var remSize = parseFloat(getComputedStyle(document.documentElement).fontSize)

      window.setInterval(function() {
        var dockedPlayer = document.querySelector('.jw-flag-floating .jw-wrapper');

        if (dockedPlayer) {
          var isCollidingWithDockedPlayer = curry(isOverlapping)(dockedPlayer);

          var possibleVisibleCollidingElements = possibleCollidingElementsSelectors
          .map(document.querySelector.bind(document))
          .filter(Boolean)
          .filter(isVisible);

          var collidingElementsHeight = possibleVisibleCollidingElements
          .filter(isCollidingWithDockedPlayer)
          .map(getHeight);

          var maxOffset = Math.max.apply(null, collidingElementsHeight);

          if (maxOffset > 0) {
            dockedPlayer.style.top = 'auto';
            dockedPlayer.style.bottom = (maxOffset + remSize) + 'px';
          } else if (!possibleVisibleCollidingElements.length) {
            dockedPlayer.style.top = 'auto';
            dockedPlayer.style.bottom = remSize + 'px';
          }
        }
      }, 300);
    },

    randomizeVideosInPlaylist: function(playerInstance, playlist) {
      function shuffle(arr) {
        var j, x, i;
        for (i = arr.length - 1; i > 0; i--) {
            j = Math.floor(Math.random() * (i + 1));
            x = arr[i];
            arr[i] = arr[j];
            arr[j] = x;
        }
        return arr;
      }

      playerInstance.load(shuffle(playlist))
    },

    initFloatingButton: function(playerInstance, jwplayerSettings, config) {
      function FloatingButton(player, topOffset) {
        this.id = 'ftr-f-b-ctn';
        this.element = null;
        this.videoStatus = 'idle';
        this.observer = null;
        this.headerVisible = false;
        this.player = player;
        this.topOffset = topOffset;

        this.updateVideoStatus = this.updateVideoStatus.bind(this);
      }
      FloatingButton.prototype = {
        show: function() {
          this.element.style.top = this.topOffset + 'px';
        },

        hide: function() {
          this.element.style.top = '-60px';
        },

        injectStyles: function(iconSrc) {
          var styles = document.createElement('style');
          styles.innerText = '#ftr-f-b-ctn { position: fixed; top: -60px; left: 0; height: 60px; z-index: 9999; padding: 0 10px; width: 100%; box-sizing: border-box; transition: top .3s ease-out; font-size: 15px; }\
          #ftr-f-b-ctn .ftr-f-b-title { background-color: #222; width: calc(100% - 30px); height: 50px; display: flex; align-items: center; vertical-align: middle; margin: 5px 0 }\
          #ftr-f-b-ctn .ftr-f-b-text { flex: 1; padding: 0 40px 0 10px; color: white }\
          #ftr-f-b-ctn .ftr-f-b-text:before { content: "Play video now - "; text-transform: uppercase; font-weight: bold; }\
          #ftr-f-b-ctn .ftr-f-b-icon { background: url("' + iconSrc + '") 50% 50% no-repeat; background-size: auto 60px; height: 60px; width: 60px; border-radius: 50%; margin-right: -30px; position: absolute; top: 0; right: 40px; z-index: 1; box-sizing: border-box; border: 1px solid #444; }\
          #ftr-f-b-ctn .ftr-f-b-icon svg { fill: white }\
          #ftr-f-b-ctn .ftr-f-b-jw-ctn { background-color: #222; padding: 5px 5px 0 5px; margin: -10px 30px 0 0; height: 0; box-sizing: border-box; overflow: hidden; transition: padding .5s ease-out, height .5s ease-out }\
          #ftr-f-b-ctn.expanded .ftr-f-b-jw-ctn { padding-bottom: 5px; }\
          #ftr-f-b-ctn.expanded .ftr-f-b-icon { background-blend-mode: overlay; background-color: #222; }\
          #ftr-f-b-ctn svg line { display: none; }\
          #ftr-f-b-ctn.expanded svg polygon { display: none; }\
          #ftr-f-b-ctn.expanded svg line { display: block; }';
          document.head.appendChild(styles);
        },

        loadIcon: function(iconSrc) {
          return new Promise(function(resolve) {
            var img = new Image();
            img.addEventListener('load', resolve);
            img.src = iconSrc;
          });
        },

        setTitle: function(title) {
          this.element.querySelector('.ftr-f-b-text').innerText = title;
        },

        injectMarkup: function() {
          this.element = document.createElement('div');
          this.element.id = this.id;
          this.element.innerHTML = '<div class="ftr-f-b-title">\
            <div class="ftr-f-b-text"></div>\
          </div>\
          <div class="ftr-f-b-icon">\
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="-10 -10 46 46">\
              <polygon points="9.33 6.69 9.33 19.39 19.3 13.04 9.33 6.69"/>\
              <line x1="8" y1="8" x2="20" y2="20" stroke="white" stroke-width="2" />\
              <line x1="8" y1="20" x2="20" y2="8" stroke="white" stroke-width="2" />\
            </svg>\
          </div>\
          <div class="ftr-f-b-jw-ctn"><div id="ftr-f-b-jw"></div></div>';

          this.player.getContainer().parentNode.appendChild(this.element);
          this.setTitle(this.player.getPlaylistItem().title);
          return Promise.resolve();
        },

        expand: function() {
          var jwContainer = this.element.querySelector('.ftr-f-b-jw-ctn');

          this.element.classList.add('expanded');
          jwContainer.style.height = jwContainer.dataset.height + 'px';
          wait(500).then(function() {
            document.body.classList.add('ftr-sticky-visible');
            this.player.getContainer().classList.add('ftr-stick');
          }.bind(this));
        },

        collapse: function() {
          var jwContainer = this.element.querySelector('.ftr-f-b-jw-ctn');

          document.body.classList.remove('ftr-sticky-visible');
          this.player.getContainer().classList.remove('ftr-stick');
          jwContainer.style.height = 0;
          wait(500).then(function() {
            this.element.classList.remove('expanded');
          }.bind(this));
        },

        onClick: function(mode) {
          switch (mode) {
            case 'sticky':
              if (this.element.classList.contains('expanded')) {
                this.collapse();
                this.player.pause();
              } else {
                this.expand();
                wait(500)
                .then(function() {
                  this.player.play();
                }.bind(this));
              }
              break;
            case 'modal':
              showVideoModal();
              break;
            default:
              break;
          }
        },

        bindClickHandler: function(mode) {
          this.element.querySelectorAll('.ftr-f-b-title,.ftr-f-b-icon').forEach(function(el) {
            el.addEventListener('click', function() {
              this.onClick(mode)
            }.bind(this))
          }.bind(this));
        },

        inject: function(iconSrc, mode) {
          return Promise.all([
            this.loadIcon(iconSrc),
            this.injectMarkup()
          ]).then(function() {
            this.bindClickHandler(mode);
          }.bind(this));
        },

        switchPlayer: function(newPlayer) {
          this.player.pause();
          this.element.querySelector('.ftr-f-b-icon').style.backgroundImage = 'url("' + newPlayer.getPlaylistItem().image + '")'
          this.setTitle(newPlayer.getPlaylistItem().title);
          this.collapse();
          if (this.observer) {
            this.observer.unobserve(this.player.getContainer().parentNode);
          }
          this.clearEventHandlers();
          this.player = newPlayer;
          this.initPlayerEvents();
          this.initStickyVisibility();
        },

        updateVideoStatus: function(event) {
          switch (event.type) {
            case 'beforePlay':
              this.videoStatus = 'playing';
              return;
            case 'playlistComplete':
              this.videoStatus = 'end';
              return;
            case 'pause':
              this.videoStatus = 'pause';
              return;
          }
        },

        clearEventHandlers: function() {
          this.player.off('beforePlay', this.updateVideoStatus);
          this.player.off('playlistComplete', this.updateVideoStatus);
          this.player.off('pause', this.updateVideoStatus);
        },

        initPlayerEvents: function() {
          this.player.on('beforePlay', this.updateVideoStatus);
          this.player.on('playlistComplete', this.updateVideoStatus);
          this.player.on('pause', this.updateVideoStatus);
        },

        initStickyVisibility: function() {
          this.observer = new AppearanceObserver(function(change) {
            if (change === 'enter') {
              this.hide();
              this.collapse();
            } else if (change === 'leave' && !this.headerVisible) {
              this.show();
              if (this.videoStatus === 'playing') {
                this.expand();
              }
            }
          }.bind(this));
          this.observer.observe(this.player.getContainer().parentNode);
        },

        initVisibility: function(mode) {
          var hide = function() {
            this.headerVisible = true;
            if (mode === 'sticky') {
              this.collapse();
              this.player.pause();
            }
            this.hide();
          }.bind(this);

          var show = function() {
            this.headerVisible = false;
            this.show();
          }.bind(this);

          var observer = new AppearanceObserver(function(change) {
            if (change === 'enter') hide();
            if (change === 'leave') show();
          }.bind(this));
          var header = document.querySelector('.header');
          if (header) {
            observer.observe(document.querySelector('.header'));
          }
        },

        storeStickyContainerHeight: function() {
          var playerContainer = this.player.getContainer();
          var playerWidth = playerContainer.getBoundingClientRect().width;
          var playerHeight = playerContainer.getBoundingClientRect().height;
          var playerSizeRatio = playerWidth / playerHeight;

          var stickyContainer = this.element.querySelector('.ftr-f-b-jw-ctn');
          var stickyContainerWidth = stickyContainer.getBoundingClientRect().width;
          var stickyContainerHeight = stickyContainerWidth / playerSizeRatio;
          stickyContainer.dataset.height = stickyContainerHeight + 5;
          var style = document.createElement('style');
          var top = 60 + Number(this.topOffset);
          style.innerText = '.ftr-sticky-visible .jwplayer.ftr-stick { position: fixed; z-index: 10000; top: ' + top + 'px; left: 15px; max-width: ' + (stickyContainerWidth - 10) + 'px; max-height: ' + (stickyContainerHeight - 10) + 'px; }'
          document.body.appendChild(style);
        }
      }

      function getModal() {
        return document.getElementById('ftr-f-b-modal');
      }

      function setVideoModalVisibility(isVisible) {
        getModal().style.display = isVisible ? 'flex' : 'none';
      }

      function hideVideoModal(playerInstance) {
        setVideoModalVisibility(false);
        playerInstance.pause();
      }

      function showVideoModal() {
        setVideoModalVisibility(true);
      }

      function refreshTitle(playerInstance) {
        getModal().querySelector('.ftr-f-b-video-title').innerText = playerInstance.getPlaylistItem().title;
      }

      function getPlaylistHTML(videos) {
        function formateDuration(duration) {
          return Math.floor(duration / 60) + ':' + (duration % 60);
        }

        return videos.map(function(video) {
          return '<li class="ftr-f-b-more-item" data-mediaid="' + video.mediaid + '">\
            <img src="' + video.image + '" class="ftr-f-b-more-item-image"></img>\
            <div class="ftr-f-b-more-item-title">' + video.title + '</div>\
            <div class="ftr-f-b-more-item-duration">' + formateDuration(video.duration) + '</div>\
          </li>';
        }).join('');
      }

      function closest(node, selector) {
        if (Element.prototype.closest) {
          return node.closest(selector)
        }

        var el = node;
        if (!document.documentElement.contains(el)) { return null; }
        do {
          if (el.matches(s)) { return el; }
          el = el.parentElement || el.parentNode;
        } while (el !== null && el.nodeType === 1);
        return null;
      }

      function setPlayerEventsHandlers(playerInstance) {
        playerInstance.on('play', function() {
          refreshTitle(playerInstance);
        });
      }

      function initNewPlayer(newInstance, settings) {
        newInstance.setup(settings);
        setPlayerEventsHandlers(newInstance);

        if (window.tmntag && tmntag.cmd) {
          tmntag.cmd.push(function(){
            try {
              tmntag.video.start('ftr-f-b-jw', settings, newInstance, 'video_content');
            } catch (e) {}
          });
        }
      }

      function bindCloseModalAction() {
        getModal().querySelector('.ftr-f-b-close').addEventListener('click', function() {
          var newInstance = window.jwplayer('ftr-f-b-jw');
          hideVideoModal(newInstance);
        });
      }

      function bindPlaylistClick(jwplayerSettings) {
        var newInstance = window.jwplayer('ftr-f-b-jw');
        var newSettings = Object.assign({}, jwplayerSettings, {autostart: true});

        getModal().addEventListener('click', function(event) {
          var minHeight = newInstance.getContainer().getBoundingClientRect().height;
          document.querySelector('.ftr-f-b-jw-ctn').style.minHeight = minHeight + 'px';

          var closestItem = closest(event.target, '.ftr-f-b-more-item');

          if (closestItem) {
            initNewPlayer(newInstance, Object.assign({}, newSettings, {
              playlist: 'https://content.jwplatform.com/v2/media/' + closestItem.dataset.mediaid
            }));
          }
        })
      }

      function injectVideoModal(videos, jwplayerSettings) {
        var modal = document.createElement('div');
        modal.id = 'ftr-f-b-modal';

        modal.innerHTML = '<div class="ftr-f-b-video-title-ctn">\
          <div class="ftr-f-b-video-title"></div>\
          <span class="ftr-f-b-close">&times;</span>\
        </div>\
        <div class="ftr-f-b-jw-ctn"><div id="ftr-f-b-jw"></div></div>\
        <div class="ftr-f-b-more-title">\
          <svg viewBox="0 0 32 32" class="ftr-f-b-more-title-icon" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:none;stroke:#fff;stroke-linejoin:round;stroke-width:2px;}</style></defs><title/><g data-name="20-List" id="_20-List"><rect class="cls-1" height="6" width="6" x="1" y="1"/><rect class="cls-1" height="6" width="6" x="1" y="13"/><rect class="cls-1" height="6" width="6" x="1" y="25"/><line class="cls-1" x1="10" x2="32" y1="2" y2="2"/><line class="cls-1" x1="10" x2="20" y1="6" y2="6"/><line class="cls-1" x1="10" x2="32" y1="14" y2="14"/><line class="cls-1" x1="10" x2="20" y1="18" y2="18"/><line class="cls-1" x1="10" x2="32" y1="26" y2="26"/><line class="cls-1" x1="10" x2="20" y1="30" y2="30"/></g></svg>\
          More Videos\
        </div>\
        <ul class="ftr-f-b-more-list">' + getPlaylistHTML(videos) + '</ul>';

        document.body.appendChild(modal);
        var newInstance = window.jwplayer('ftr-f-b-jw');
        var newSettings = Object.assign({}, jwplayerSettings, {autostart: true});
        initNewPlayer(newInstance, newSettings);
        refreshTitle(playerInstance);
      }

      function injectModalStyles() {
        var styles = document.createElement('style');
        styles.innerText = '#ftr-f-b-modal { display: none; width: 100%; height: 100%; flex-direction: column; color: white; font-weight: bold; font-size: smaller; background-color: #222; position: fixed; top: 0; left: 0; z-index: 10000; padding: 5px; box-sizing: border-box; }\
        #ftr-f-b-modal .ftr-f-b-video-title-ctn { padding: 0 10px 3px; }\
        #ftr-f-b-modal .ftr-f-b-close { position: absolute; right: 5px; top: 1px; font-size: 30px; width: 30px; height: 30px; line-height: 30px; text-align: center; }\
        #ftr-f-b-modal .ftr-f-b-more-list { padding: 0 10px; overflow: scroll; }\
        #ftr-f-b-modal .ftr-f-b-more-title-icon { max-width: 15px; position: absolute; margin: 2px 0 0 -25px; }\
        #ftr-f-b-modal .ftr-f-b-more-title { margin: 10px -10px; padding: 5px 10px 0 46px; border-bottom: 1px solid grey; }\
        #ftr-f-b-modal .ftr-f-b-more-item { display: grid; grid-template-columns: 40% 10px 1fr; grid-template-rows: auto auto 1fr; grid-template-areas: "image . title" "image . duration" "image . ."; margin-top: 10px; }\
        #ftr-f-b-modal .ftr-f-b-more-item-image { grid-area: image; max-width: 100%; }\
        #ftr-f-b-modal .ftr-f-b-more-item-title { grid-area: title }\
        #ftr-f-b-modal .ftr-f-b-more-item-duration { grid-area: duration; color: lightgrey; font-size: smaller; }';
        document.head.appendChild(styles);
      }

      function wait(time) {
        return new Promise(function(resolve) {
          window.setTimeout(resolve, time);
        });
      }

      function retrievePlaylist(playlistSrc) {
        return new Promise(function(resolve, reject) {
          var req = new XMLHttpRequest()
          req.open('GET', playlistSrc, true);
          req.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE) {
              if (this.status === 200) {
                try {
                  var playlistData = JSON.parse(this.responseText);
                  resolve(playlistData.playlist);
                } catch (err) {
                  reject({error: err})
                }
              } else {
                reject({status: this.status, responseText: this.responseText})
              }
            }
          }
          req.send(null);
        })
      }

      function bindPlayerClick(player, floatingButton) {
        player.on('displayClick', function() {
          if (player === floatingButton.player) {
            // the player is already displayed in the floating button
            return;
          }

          floatingButton.switchPlayer(player);
          player.play();
        })
      }

      function AppearanceObserver(fn) {
        return new IntersectionObserver(function(changes) {
          if (changes && changes.length) {
            if (changes[0].intersectionRatio <= 0) {
              fn('leave');
            } else {
              fn('enter');
            }
          }
        })
      }

      if (config.device !== 'mobile' || !window.Promise) {
        return;
      }

      var floatingButton = this.floatingButtonInstance = this.floatingButtonInstance || new FloatingButton(playerInstance, config.topOffset);
      bindPlayerClick(playerInstance, floatingButton);

      if (document.getElementById(floatingButton.id)) {
        // floating button already initialized for another video in page
        return;
      }

      var iconSrc = playerInstance.getPlaylistItem().image;
      if (iconSrc) {
        floatingButton.injectStyles(iconSrc);
        switch (config.mode) {
          case 'modal':
            injectModalStyles();
            retrievePlaylist(config.playlistSrc)
            .then(function(videos) { return injectVideoModal(videos, jwplayerSettings); })
            .then(function() {
              bindCloseModalAction();
              bindPlaylistClick(jwplayerSettings);
            })
            .then(function() { return floatingButton.inject(iconSrc, config.mode) })
            .then(function() { return floatingButton.initVisibility(config.mode); })
            break;
          case 'sticky':
            floatingButton.inject(iconSrc, config.mode)
            .then(function() { floatingButton.initPlayerEvents(); })
            .then(function() { return floatingButton.storeStickyContainerHeight(); })
            .then(function() { return floatingButton.initVisibility(config.mode) })
            .then(function() { return floatingButton.initStickyVisibility(); })
            break;
        }
      }
    }
  };

  window.Purch = window.Purch || {};
  window.Purch.Jwplayer = Jwplayer;
})();
