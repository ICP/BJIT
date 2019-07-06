'use strict';
!function() {
  /**
   * @return {?}
   */
  function random() {
    try {
      var _crypto = window.crypto || window.msCrypto;
      if (_crypto && _crypto.getRandomValues) {
        return _crypto.getRandomValues(new Uint32Array(1))[0].toString(36);
      }
    } catch (e) {
    }
    return Math.random().toString(36).slice(2, 9);
  }
  /**
   * @param {number} b
   * @return {?}
   */
  function guid(b) {
    /** @type {string} */
    var res = "";
    for (; res.length < b;) {
      /** @type {string} */
      res = res + random();
    }
    return res.slice(0, b);
  }
  /**
   * @param {?} uuid
   * @return {?}
   */
  function translate(uuid) {
    if (uuid) {
      if (/vast/.test(uuid)) {
        return 0;
      }
      if (/googima/.test(uuid)) {
        return 1;
      }
      if (/freewheel/.test(uuid)) {
        return 2;
      }
      if (/dai/.test(uuid)) {
        return 3;
      }
    }
    return -1;
  }
  /**
   * @param {string} att
   * @return {?}
   */
  function nativeIsFinite(att) {
    return /^[a-zA-Z0-9]{8}$/.test(att);
  }
  /**
   * @param {number} height
   * @return {?}
   */
  function createElement(height) {
    var valueMightNeedDecoding = !(1 < arguments.length && void 0 !== arguments[1]) || arguments[1];
    if ("number" != typeof height) {
      return null;
    }
    /** @type {number} */
    var value = height / 1e3;
    return valueMightNeedDecoding ? Math.round(value) : value;
  }
  /**
   * @param {string} str
   * @param {string} type
   * @return {?}
   */
  function get(str, type) {
    return str + "-" + type;
  }
  /**
   * @param {!Object} message
   * @param {string} type
   * @return {?}
   */
  function replace(message, type) {
    return type.split(".").reduce(function(marketOutcomesData, outcomeID) {
      return marketOutcomesData ? marketOutcomesData[outcomeID] : void 0;
    }, message);
  }
  /**
   * @param {!Object} q
   * @param {string} propertyName
   * @return {?}
   */
  function f(q, propertyName) {
    /** @type {string} */
    var exactLanguageCode = " " + propertyName + " ";
    return 1 === q.nodeType && 0 <= (" " + q.className + " ").replace(/[\t\r\n\f]/g, " ").indexOf(exactLanguageCode);
  }
  /**
   * @param {!Object} object
   * @return {?}
   */
  function process(object) {
    var media = object.getContainer().querySelector("video");
    return media ? media.currentTime : object.getPosition();
  }
  /**
   * @param {!Object} instance
   * @return {?}
   */
  function listener(instance) {
    try {
      return instance.getPlaylistItem();
    } catch (e) {
      var vid = instance.getPlaylistIndex();
      return instance.getConfig().playlist[vid] || null;
    }
  }
  /**
   * @param {?} m
   * @return {?}
   */
  function stringify(m) {
    if ("function" == typeof m.getProvider) {
      var orderShippingMethod = m.getProvider();
      return orderShippingMethod ? orderShippingMethod.name : "";
    }
    return "";
  }
  /**
   * @param {!Object} path
   * @return {?}
   */
  function H(path) {
    var isOwner = 1 < arguments.length && void 0 !== arguments[1] && arguments[1];
    var options = path.getVisualQuality();
    var data = void 0;
    if (options && options.level) {
      /** @type {(boolean|null)} */
      var r = "string" == typeof options.mode ? "auto" === options.mode : null;
      data = {
        width : options.level.width,
        height : options.level.height,
        bitrate : createElement(options.level.bitrate),
        reason : options.reason,
        adaptiveBitrateMode : r
      };
    } else {
      data = {
        width : null,
        height : null,
        bitrate : null,
        reason : null,
        adaptiveBitrateMode : null
      };
    }
    return c && !isOwner || (c = data), data;
  }
  /**
   * @param {!Object} item
   * @return {?}
   */
  function getDuration(item) {
    var innerActiontimeline = item.external.playerAPI;
    var object = item.meta.playbackEvents;
    var firstDuration = innerActiontimeline.getDuration();
    if (firstDuration <= 0) {
      var result = object[name];
      if (result) {
        firstDuration = result.duration;
      }
    }
    return 0 | firstDuration;
  }
  /**
   * @param {!Object} o
   * @param {!Node} f
   * @param {string} x
   * @return {undefined}
   */
  function create(o, f, x) {
    if (f.parentNode) {
      f.parentNode.removeChild(f);
    }
    /** @type {string} */
    f.src = x;
    o.appendChild(f);
  }
  /**
   * @return {?}
   */
  function link() {
    /** @type {(Element|null)} */
    var element = document.getElementById(TEXT_SIZE_CONTAINER_ID);
    return element || ((element = document.createElement("iframe")).setAttribute("id", TEXT_SIZE_CONTAINER_ID), element.style.display = "none"), element;
  }
  /**
   * @param {!Object} obj
   * @param {?} item
   * @return {undefined}
   */
  function fn(obj, item) {
    var strings = {
      PARAM_ANALYTICS_TOKEN : item.analyticsID,
      PARAM_MEDIA_ID : item.mediaID,
      EMBED_ID : item.embedID,
      ITEM_ID : item.playID,
      PARAM_EXTERNAL_ID : item.externalID,
      PARAM_XID_ALGORITHM_VERSION : item.xidAlgorithmVersion,
      PARAM_PLAYER_VERSION : item.playerVersion,
      PARAM_TRACKER_VERSION : item.trackerVersion
    };
    var t = Object.keys(strings).reduce(function(src, n) {
      var string = strings[n];
      return null == string ? src : src + (src.length ? "&" : "") + formats[n] + "=" + encodeURIComponent(string);
    }, "");
    create(obj, link(), "//g.jwpsrv.com/g/gcid-0.1.0.html?" + t);
  }
  /**
   * @param {!Object} data
   * @return {undefined}
   */
  function success(data) {
    if (function(options) {
      if (!options.browser.allowUserTracking) {
        return false;
      }
      var self = options.external.playerAPI;
      try {
        if (self.getEnvironment) {
          var data = self.getEnvironment();
          return !(data.Browser.facebook && data.OS.iOS);
        }
        return !(self.utils.isFacebook() && self.utils.isIOS());
      } catch (e) {
        return false;
      }
    }(data) && (data.playlistItemData.mediaId || data.playlistItemData.externalId)) {
      var div = data.external.div;
      var cell = {
        analyticsID : data.accountData.analyticsID,
        mediaID : data.playlistItemData.mediaId,
        embedID : data.staticPlayerData.embedID,
        playID : data.playlistItemData.itemId,
        externalID : data.playlistItemData.externalId,
        xidAlgorithmVersion : data.meta.xidAlgorithmVersion,
        playerVersion : data.staticPlayerData.playerVersion,
        trackerVersion : "3.5.5"
      };
      /** @type {(Element|null)} */
      var file = document.querySelector('[src*="' + oe + '"]');
      if (!file || file.complete || file.width) {
        setTimeout(function() {
          return fn(div, cell);
        });
      } else {
        /** @type {!Element} */
        args = file;
        parent = div;
        type = cell;
        _takingTooLongTimeout = void 0;
        /** @type {number} */
        initializeCheckTimer = setInterval(function() {
          if (args.width || args.complete) {
            clearInterval(initializeCheckTimer);
            clearTimeout(_takingTooLongTimeout);
            fn(parent, type);
          }
        }, 250);
        /** @type {number} */
        _takingTooLongTimeout = setTimeout(function() {
          clearInterval(initializeCheckTimer);
          fn(parent, type);
        }, 1E3);
      }
    }
    var args;
    var parent;
    var type;
    var _takingTooLongTimeout;
    var initializeCheckTimer;
  }
  /**
   * @param {!Object} self
   * @param {!Object} arg
   * @param {string} node
   * @return {?}
   */
  function init(self, arg, node) {
    var interestingPoint;
    /** @type {(number|undefined)} */
    var width = arg.sdkplatform ? parseInt(arg.sdkplatform, 10) : void 0;
    var o = self.getConfig();
    var target = (o || {}).advertising || {};
    var horAdjust = ha = ha + 1;
    var viewportCenter = "doNotTrack" in navigator || "doNotTrack" in window || "msDoNotTrack" in navigator ? navigator.doNotTrack || window.doNotTrack || navigator.msDoNotTrack : "unsupported";
    /** @type {boolean} */
    var l = null == (interestingPoint = viewportCenter) || -1 === values.indexOf(interestingPoint.toString());
    var compType = void 0;
    var realValue = void 0;
    if (l) {
      var prop = function() {
        if (!storage) {
          return {
            localID : null,
            storageAvailable : "fail"
          };
        }
        var oldDelFromStorage = storage.jwplayerLocalId;
        if (oldDelFromStorage) {
          return {
            localID : oldDelFromStorage,
            storageAvailable : "read"
          };
        }
        try {
          return storage.jwplayerLocalId = guid(12), {
            localID : storage.jwplayerLocalId,
            storageAvailable : "set"
          };
        } catch (e) {
          return {
            localID : null,
            storageAvailable : "fail"
          };
        }
      }();
      compType = prop.localID;
      realValue = prop.storageAvailable;
    } else {
      if (storage) {
        storage.removeItem("jwplayerLocalId");
      }
      create(node, link(), "//g.jwpsrv.com/g/gcid-0.1.0.html?notrack");
    }
    var $html;
    var options;
    var device;
    var props;
    var data;
    var dateLabelText;
    var el;
    var $el;
    var whatToScale;
    var result;
    var tiapp;
    /** @type {(null|string)} */
    var S = ($html = document.querySelector("html")) ? $html.getAttribute("lang") : null;
    /** @type {boolean} */
    var T = window.matchMedia && window.matchMedia("(display-mode: standalone)").matches || true === window.navigator.standalone;
    var P = function() {
      try {
        if (window.top !== window.self) {
          return window.top.document.referrer;
        }
      } catch (e) {
        return null;
      }
      return document.referrer;
    }();
    var A = o.defaultPlaybackRate || 1;
    var translatedHTML = translate(target.client);
    return self.getPlugin && self.getPlugin("related"), {
      external : {
        playerAPI : self,
        div : node,
        utils : self.utils
      },
      playerData : {
        setupTime : -1,
        visualQuality : H(self),
        lastErrorCode : {},
        defaultPlaybackRate : A,
        playerConfig : {
          visibility : -1,
          bandwidthEstimate : -1
        },
        playerSize : {
          width : 0,
          height : 0,
          bucket : 0
        },
        localization : {
          language : o.language,
          numIntlKeys : "object" == typeof o.intl ? Object.keys(o.intl).length : null,
          numLocalKeys : "object" == typeof o.localization ? Object.keys(o.localization).length : null
        },
        contextualEmbed : !!o.contextual
      },
      staticPlayerData : (el = self, $el = arg, whatToScale = width, tiapp = {
        playerVersion : (result = el.version, result.split("+")[0]),
        sdkPlatform : $el.sdkplatform || 0,
        embedID : guid(12)
      }, whatToScale && (tiapp.sdkVersion = $el.iossdkversion), tiapp),
      casting : false,
      accountData : function(b, RegExp) {
        /** @type {number} */
        var edition = 0;
        var showTooltipPercent = void 0;
        if (b) {
          var query = new RegExp(b);
          var createLocalDescription = query.edition();
          if ((edition = test[createLocalDescription] || 0) !== invalid) {
            showTooltipPercent = query.token();
          }
        }
        return showTooltipPercent || (showTooltipPercent = "_"), {
          analyticsID : showTooltipPercent,
          edition : edition
        };
      }(o.key, self.utils.key),
      configData : (options = o, props = window.jwplayer && window.jwplayer.defaults || {}, data = options.related, dateLabelText = {
        playerHosting : options[i] || props[i] || 0,
        playerConfigKey : options.pid,
        abTestConfig : options.pad,
        skinName : options.skin,
        advertisingBlockType : (device = options, device.advertising ? device.advertising.outstream ? 2 : 1 : 0),
        sharingEnabled : !!options.sharing,
        castingBlockPresent : !!options.cast,
        gaBlockPresent : !!options.ga,
        autostartConfig : !!options.autostart,
        visualPlaylist : false !== options.visualplaylist,
        displayDescription : false !== options.displaydescription,
        posterImagePresent : !!options.image,
        playbackRateControlsSet : !!options.playbackRateControls,
        relatedPluginConfigPresent : !!data
      }, options.autostart in eventItem && (dateLabelText.autostartConfig = eventItem[options.autostart]), data && (dateLabelText.relatedPluginFeedFile = data.recommendations || data.file), dateLabelText),
      browser : {
        langAttr : S,
        isPageStandalone : T,
        docReferrer : P,
        storage : {
          localID : compType,
          storageAvailable : realValue,
          doNotTrackProperty : viewportCenter
        },
        pageData : function(workingImageWidth) {
          if (workingImageWidth) {
            return {
              pageViewId : $uniqueId
            };
          }
          /** @type {string} */
          var url = "";
          /** @type {string} */
          var label = "";
          /** @type {boolean} */
          var n = window.top !== window.self;
          if (n) {
            /** @type {string} */
            url = document.referrer;
            try {
              /** @type {string} */
              url = url || window.top.location.href;
              label = window.top.document.title;
            } catch (e) {
            }
          }
          /** @type {(Element|null)} */
          var r = document.querySelector('meta[property="og:title"]');
          var s = void 0;
          return r && (s = r.getAttribute("content")), {
            pageURL : url || window.location.href,
            pageTitle : label || document.title,
            inIframe : n,
            flashVersion : slideBackward(),
            pageViewId : $uniqueId,
            pageOGTitle : s
          };
        }(width),
        allowUserTracking : l
      },
      meta : {
        debug : true === arg.debug,
        setupCount : ha,
        nthPlayer : horAdjust,
        playbackEvents : {},
        playbackSent : void 0,
        playbackTracking : {
          trackingSegment : void 0,
          playedSeconds : 0,
          viewablePlayedSeconds : 0,
          playedSecondsTotal : 0,
          previousTime : null,
          segmentReceived : false,
          segmentsEncrypted : false,
          playItemCount : 0,
          playSessionSequence : 0,
          prevPlaybackRate : A,
          retTimeWatched : 0,
          normalizedTime : -1,
          elapsedSeconds : 0,
          viewableElapsedSeconds : 0,
          currentPosition : 0
        },
        bufferedPings : [],
        seekTracking : {
          numTrackedSeeks : 0,
          videoStartDragTime : 0,
          dragStartTime : 0,
          seekDebounceTimeout : -1,
          lastTargetTime : 0
        },
        previousBufferTimes : {},
        lastEvent : "",
        lastBucket : "",
        eventPreAbandonment : void 0,
        playerState : "idle",
        playerStateDuration : 0,
        playerRemoved : false
      },
      playlistItemData : {
        ready : void 0,
        item : {},
        drm : "",
        index : 0,
        itemId : "",
        mediaId : "",
        playReason : "",
        duration : 0
      },
      related : {
        shownReason : null,
        nextShownReason : null,
        sendHoverPing : null,
        feedId : null,
        feedInstanceId : null,
        feedType : null,
        onClickSetting : -1,
        feedInterface : null,
        idsShown : [],
        thumbnailIdsShown : [],
        pinnedCount : -1,
        page : -1,
        autotimerLength : -1,
        pinSetId : -1,
        advanceTarget : null,
        ordinalClicked : -1
      },
      sharing : {
        shareMethod : null,
        shareReferrer : function(_testModuleName) {
          if (!_testModuleName) {
            return null;
          }
          /** @type {(Array<string>|null)} */
          var cookie = _testModuleName.match(/[?&]jwsource=([^&]+)/);
          return cookie ? decodeURIComponent(cookie[1]) : null;
        }(window.location.search)
      },
      ads : {
        adEventData : merge({}, defaults),
        advertisingConfig : target,
        adClient : translatedHTML,
        adScheduleId : target.adscheduleid,
        VAST_URL_SAMPLE_RATE : 6E-5,
        adBreakTracking : -1 !== translatedHTML ? {
          shouldTrack : false,
          adBreakCount : 0
        } : null,
        headerBiddingData : {},
        watchedPastSkipPoint : null,
        jwAdErrorCode : null,
        currentQuartile : null,
        creativeId : null,
        adTitle : null
      },
      errors : {
        SAMPLE_RATE : .02,
        NUM_ERRORS_PER_SESSION : 1,
        numberEventsSent : 0
      },
      trackingState : {
        pageLoaded : null,
        queue : [],
        onping : "function" == typeof arg.onping ? arg.onping : null,
        images : [],
        boundFlushQueue : null
      }
    };
  }
  /**
   * @param {string} b
   * @param {number} v
   * @return {?}
   */
  function m(b, v) {
    var padding;
    var stepSize;
    var seed;
    var i;
    var c2;
    var c1;
    var k1;
    var j;
    /** @type {number} */
    padding = 3 & b.length;
    /** @type {number} */
    stepSize = b.length - padding;
    /** @type {number} */
    seed = v;
    /** @type {number} */
    c2 = 3432918353;
    /** @type {number} */
    c1 = 461845907;
    /** @type {number} */
    j = 0;
    for (; j < stepSize;) {
      /** @type {number} */
      k1 = 255 & b.charCodeAt(j) | (255 & b.charCodeAt(++j)) << 8 | (255 & b.charCodeAt(++j)) << 16 | (255 & b.charCodeAt(++j)) << 24;
      ++j;
      /** @type {number} */
      seed = 27492 + (65535 & (i = 5 * (65535 & (seed = (seed = seed ^ (k1 = (65535 & (k1 = (k1 = (65535 & k1) * c2 + (((k1 >>> 16) * c2 & 65535) << 16) & 4294967295) << 15 | k1 >>> 17)) * c1 + (((k1 >>> 16) * c1 & 65535) << 16) & 4294967295)) << 13 | seed >>> 19)) + ((5 * (seed >>> 16) & 65535) << 16) & 4294967295)) + ((58964 + (i >>> 16) & 65535) << 16);
    }
    switch(k1 = 0, padding) {
      case 3:
        /** @type {number} */
        k1 = k1 ^ (255 & b.charCodeAt(j + 2)) << 16;
      case 2:
        /** @type {number} */
        k1 = k1 ^ (255 & b.charCodeAt(j + 1)) << 8;
      case 1:
        /** @type {number} */
        seed = seed ^ (k1 = (65535 & (k1 = (k1 = (65535 & (k1 = k1 ^ 255 & b.charCodeAt(j))) * c2 + (((k1 >>> 16) * c2 & 65535) << 16) & 4294967295) << 15 | k1 >>> 17)) * c1 + (((k1 >>> 16) * c1 & 65535) << 16) & 4294967295);
    }
    return seed = seed ^ b.length, seed = 2246822507 * (65535 & (seed = seed ^ seed >>> 16)) + ((2246822507 * (seed >>> 16) & 65535) << 16) & 4294967295, seed = 3266489909 * (65535 & (seed = seed ^ seed >>> 13)) + ((3266489909 * (seed >>> 16) & 65535) << 16) & 4294967295, (seed = seed ^ seed >>> 16) >>> 0;
  }
  /**
   * @param {!Object} args
   * @return {?}
   */
  function index(args) {
    return next(args, "feedid");
  }
  /**
   * @param {!Object} value
   * @return {?}
   */
  function expect(value) {
    return next(value, "feed_instance_id");
  }
  /**
   * @param {string} txt
   * @return {?}
   */
  function method(txt) {
    return txt ? txt.pin_set_id : null;
  }
  /**
   * @param {!Object} item
   * @param {string} name
   * @return {?}
   */
  function next(item, name) {
    return item ? (item.feedData || {})[name] || item[name] : null;
  }
  /**
   * @param {!Object} options
   * @return {?}
   */
  function $(options) {
    if (!options) {
      return null;
    }
    var data;
    var eventsToRender;
    var n = options.mediaid;
    return nativeIsFinite(n) ? n : (data = options.file, nativeIsFinite(n = (eventsToRender = /.*\/(?:manifests|videos)\/([a-zA-Z0-9]{8})[\.-].*/.exec(data)) && 2 === eventsToRender.length ? eventsToRender[1] : null) ? n : null);
  }
  /**
   * @param {string} data
   * @return {?}
   */
  function compile(data) {
    return data ? data.title : null;
  }
  /**
   * @param {!Object} params
   * @param {string} options
   * @return {undefined}
   */
  function find(params, options) {
    var paramsInfo = void 0;
    if (Ie[params.accountData.analyticsID]) {
      paramsInfo = function(search, code) {
        var program = compile(code);
        if (program) {
          return function(type, i) {
            /** @type {number} */
            type.meta.xidAlgorithmVersion = 1;
            var b = m(i, k);
            var c = m(i + i, k);
            return "01_" + b + c;
          }(search, program);
        }
      }(params, options);
    }
    var externalId = paramsInfo || options.externalId;
    if ((params.playlistItemData.externalId = externalId) && !params.meta.xidAlgorithmVersion) {
      /** @type {number} */
      params.meta.xidAlgorithmVersion = 0;
    }
  }
  /**
   * @param {number} variable
   * @return {?}
   */
  function resolve(variable) {
    return variable === 1 / 0 ? 1 / 0 : (variable = variable | 0) <= 0 ? 0 : variable < 30 ? 1 : variable < 60 ? 4 : variable < 180 ? 8 : variable < 300 ? 16 : 32;
  }
  /**
   * @param {!Object} context
   * @return {?}
   */
  function cb(context) {
    try {
      return context.external.playerAPI.qoe().item.sums.stalled || 0;
    } catch (e) {
      return 0;
    }
  }
  /**
   * @param {!NodeList} state
   * @param {!Function} stream
   * @return {?}
   */
  function read(state, stream) {
    /** @type {number} */
    var j = 0;
    for (; j < state.length; j++) {
      if (stream(state[j])) {
        return state[j];
      }
    }
    return null;
  }
  /**
   * @param {!Object} value
   * @return {?}
   */
  function ajaxSaveCaseExecution(value) {
    if (!value.bidders) {
      return {};
    }
    var a = function(data) {
      var a = read(data.bidders, function(engineDiscovery) {
        return "SpotX" === engineDiscovery.name;
      });
      if (!a) {
        return {};
      }
      return {
        spotxBid : args[a.result],
        spotxBidPrice : a.priceInCents,
        spotxBidWon : a.winner,
        spotxAdPubId : a.id,
        spotxResTime : a.timeForBidResponse
      };
    }(value);
    var val = function(data) {
      var a = read(data.bidders, function(engineDiscovery) {
        return "FAN" === engineDiscovery.name;
      });
      if (!a) {
        return {};
      }
      return {
        fanBid : args[a.result],
        fanBidPrice : a.priceInCents,
        fanBidWon : a.winner,
        fanAdPubId : a.id,
        fanResTime : a.timeForBidResponse
      };
    }(value);
    var heatZone = value.floorPriceCents;
    return merge({
      mediationLayer : generatedSlugs[value.mediationLayerAdServer],
      floorPriceCents : heatZone
    }, a, val);
  }
  /**
   * @param {?} name
   * @param {!Object} res
   * @return {?}
   */
  function wrap(name, res) {
    var item = socket.events[name];
    var sActionName = item.parameterGroups.reduce(function(result, name) {
      return result.concat(socket.paramGroups[name].members);
    }, []).concat(item.pingSpecificParameters ? item.pingSpecificParameters : []).map(function(b) {
      return e = res, reject = opts[a = b] ? opts[a] : function() {
        if (e.meta.debug) {
          console.log("No parameter generation function for param " + a);
        }
      }, {
        code : a,
        value : reject(e)
      };
      var a;
      var e;
      var reject;
    });
    return {
      event : item.code,
      bucket : item.bucket,
      parameters : sActionName
    };
  }
  /**
   * @param {!Object} data
   * @param {string} e
   * @param {string} n
   * @return {undefined}
   */
  function update(data, e, n) {
    var value = data.external.playerAPI;
    var self = value.getConfig();
    data.playerData.playerConfig = {
      visibility : self.visibility,
      bandwidthEstimate : self.bandwidthEstimate
    };
    var c;
    var id;
    var o;
    var prev = listener(value) || {};
    data.playlistItemData.item = prev;
    data.playlistItemData.mediaId = $(prev);
    data.playerData.playerSize = function(view) {
      var self = view.getConfig();
      var width = self.containerWidth || view.getWidth();
      var height = self.containerHeight || view.getHeight();
      if (/\d+%/.test(width)) {
        var imagenElement = view.utils.bounds(view.getContainer());
        width = imagenElement.width;
        height = imagenElement.height;
      }
      return width = 0 | Math.round(width), height = 0 | Math.round(height), /\d+%/.test(self.width || width) && self.aspectratio ? {
        bucket : destBucketName,
        width : width,
        height : height
      } : f(view.getContainer(), "jw-flag-audio-player") ? {
        bucket : bucketName,
        width : width,
        height : height
      } : 0 === width ? {
        bucket : normalBucket,
        width : width,
        height : height
      } : width <= 320 ? {
        bucket : storageBucket,
        width : width,
        height : height
      } : width <= 640 ? {
        bucket : bucket,
        width : width,
        height : height
      } : {
        bucket : fbucket,
        width : width,
        height : height
      };
    }(value);
    data.playlistItemData.duration = getDuration(data);
    /** @type {string} */
    data.meta.lastEvent = e;
    /** @type {string} */
    data.meta.lastBucket = n;
    data.playerData.visualQuality = H(value, "s" === e && "jwplayer6" === n);
    data.playerData.defaultPlaybackRate = self.defaultPlaybackRate;
    find(data, prev);
    /** @type {!Object} */
    c = data;
    /** @type {string} */
    id = e;
    /** @type {string} */
    o = n;
    if (-1 === inputs.indexOf(id)) {
      c.meta.eventPreAbandonment = get(id, o);
    }
  }
  /**
   * @param {!Window} options
   * @return {undefined}
   */
  function initialize(options) {
    var firmList = options.external.playerAPI;
    /** @type {boolean} */
    var ready = "complete" === (firmList.getContainer().ownerDocument || window.document).readyState;
    if (!(options.trackingState.pageLoaded = ready)) {
      options.trackingState.boundFlushQueue = start.bind(null, options);
      if (window.addEventListener) {
        window.addEventListener("load", options.trackingState.boundFlushQueue);
      }
      setTimeout(options.trackingState.boundFlushQueue, 5E3);
    }
  }
  /**
   * @param {!Object} node
   * @param {!Object} data
   * @return {?}
   */
  function complete(node, data) {
    var s = data.event;
    var b = data.bucket;
    var args = data.parameters;
	// Farid
    // var result = add(s, b, args);
    /** @type {boolean} */
    var o = !node.trackingState.pageLoaded;
    if (o && (s === end || s === sustain || s === AS)) {
      start(node);
    } else {
      if (o) {
		  // Farid
        // return void node.trackingState.queue.push(result);
      }
    }
	// Farid
    // animate(node, result);
  }
  /**
   * @param {!Object} self
   * @param {string} path
   * @return {undefined}
   */
  function animate(self, path) {
    /** @type {!Image} */
    var data = new Image;
    var fileData = void 0;
    try {
      /** @type {number} */
      fileData = Date.now();
    } catch (e) {
    }
    /** @type {string} */
    data.src = path + "&" + file + "=" + fileData;
    var images = self.trackingState.images;
    var i = images.length;
    for (; i-- && (images[i].width || images[i].complete);) {
      images.length = i;
    }
    if (images.push(data), self.meta.debug && self.trackingState.onping) {
      try {
        self.trackingState.onping.call(null, path);
      } catch (e) {
      }
    }
  }
  /**
   * @param {!Object} value
   * @param {string} id
   * @return {?}
   */
  function callback(value, id) {
    var k = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : "jwplayer6";
    var options = 3 < arguments.length && void 0 !== arguments[3] ? arguments[3] : {};
    /** @type {!Object} */
    options = merge({}, REDSHIFT_OPTIONS, options);
    update(value, id, k);
    var type = get(id, k);
    if (!(socket.events[type].filters || []).map(function(cat_axis) {
      return c = value, scales[cat_axis](c);
      var c;
    }).some(function(canCreateDiscussions) {
      return !!canCreateDiscussions;
    })) {
      var data = wrap(type, value);
      return options.delaySend ? complete.bind(null, value, data) : options.returnURL ? add(data.event, data.bucket, data.parameters) : void complete(value, data);
    }
  }
  /**
   * @param {!Object} el
   * @return {?}
   */
  function insertAd(el) {
    return 0 < el.numTrackedSeeks;
  }
  /**
   * @param {!Object} prop
   * @return {undefined}
   */
  function filter(prop) {
    prop.meta.playbackTracking.playItemCount++;
    callback(prop, "s");
  }
  /**
   * @param {!Object} options
   * @param {string} name
   * @return {?}
   */
  function fetch(options, name) {
    return function(item) {
      var m = options.meta.playbackEvents;
      var t = options.playlistItemData;
      var info = options.meta.playbackTracking;
      var data = options.external.playerAPI;
      var ao = m[name];
      if (name === dim) {
        var o = (item.metadata || item).TXXX;
        if (o) {
          var dateValue = o.programDateTime;
          if (dateValue) {
            /** @type {number} */
            var date = Date.parse(dateValue);
            if (!isNaN(date)) {
              error(options, info.playedSeconds || 1, info.viewablePlayedSeconds || 1);
            }
          }
        }
        var segment = item.segment;
        if (segment) {
          /** @type {boolean} */
          options.meta.playbackTracking.segmentReceived = true;
          options.meta.playbackTracking.segmentsEncrypted = segment.encryption;
        }
        t.drm = item.drm || "";
      }
      if (m[name] = item, name === addedRelations && (ao || (info.playedSeconds = 0, info.viewablePlayedSeconds = 0, info.playedSecondsTotal = 0), info.previousTime = process(data)), name === thead) {
        if ("flash_adaptive" === stringify(data)) {
          if (!options.meta.playbackSent && info.segmentReceived) {
            /** @type {boolean} */
            options.meta.playbackSent = true;
            /** @type {boolean} */
            info.segmentReceived = false;
            filter(options);
          }
        } else {
          if (!options.meta.playbackSent) {
            /** @type {boolean} */
            options.meta.playbackSent = true;
            filter(options);
          }
        }
      }
    };
  }
  /**
   * @param {!Object} obj
   * @param {number} tx
   * @param {number} _2
   * @return {undefined}
   */
  function error(obj, tx, _2) {
    /** @type {number} */
    obj.meta.playbackTracking.playedSeconds = 0;
    /** @type {number} */
    var secs = tx + .5 | (obj.meta.playbackTracking.viewablePlayedSeconds = 0);
    /** @type {number} */
    obj.meta.playbackTracking.elapsedSeconds = secs;
    /** @type {number} */
    var r = _2 + .5 | 0;
    /** @type {number} */
    obj.meta.playbackTracking.viewableElapsedSeconds = r;
    if (0 < secs) {
      callback(obj, "t");
    }
  }
  /**
   * @param {!Object} x
   * @param {number} y
   * @param {number} r
   * @param {number} i
   * @return {undefined}
   */
  function reducer(x, y, r, i) {
    if (y < i && i <= y + r) {
      /** @type {number} */
      x.meta.playbackTracking.retTimeWatched = i;
      callback(x, "ret");
    }
  }
  /**
   * @param {!Object} t
   * @param {!Object} p
   * @return {undefined}
   */
  function render(t, p) {
    var me;
    var position;
    if (2 < arguments.length && void 0 !== arguments[2] && arguments[2]) {
      (function(b) {
        var track = b.meta.seekTracking;
        if (insertAd(track)) {
          clearTimeout(track.seekDebounceTimeout);
          var r = callback(b, "vs", "jwplayer6", {
            delaySend : true
          });
          /** @type {number} */
          track.seekDebounceTimeout = setTimeout(function() {
            var lastTrackTitle;
            if (r) {
              r();
            }
            /** @type {number} */
            (lastTrackTitle = track).videoStartDragTime = 0;
            /** @type {number} */
            lastTrackTitle.dragStartTime = 0;
            /** @type {number} */
            lastTrackTitle.seekDebounceTimeout = -1;
            /** @type {number} */
            lastTrackTitle.lastTargetTime = 0;
            /** @type {number} */
            lastTrackTitle.numTrackedSeeks = 0;
          }, duration);
        }
      })(t);
    } else {
      me = t.meta.seekTracking;
      /** @type {!Object} */
      position = p;
      if (!insertAd(me)) {
        me.videoStartDragTime = position.position;
        /** @type {number} */
        me.dragStartTime = Date.now();
      }
      me.numTrackedSeeks++;
      me.lastTargetTime = position.offset;
    }
  }
  /**
   * @param {!Object} message
   * @param {string} f
   * @param {?} data
   * @return {undefined}
   */
  function save(message, f, data) {
    var msgObj;
    var highFrequency;
    message.playerData.lastErrorCode[f] = data.code;
    message.meta.eventPreAbandonment = get(f, "error");
    if (message.errors.numberEventsSent < message.errors.NUM_ERRORS_PER_SESSION && (highFrequency = f, "number" == typeof(msgObj = message).playerData.lastErrorCode[highFrequency] || Math.random() < msgObj.errors.SAMPLE_RATE)) {
      message.errors.numberEventsSent += 1;
      callback(message, f, event);
    }
  }
  /**
   * @param {!Object} obj
   * @param {!Object} topic
   * @return {undefined}
   */
  function debug(obj, topic) {
    if (obj.meta.playerState !== topic) {
      /** @type {number} */
      obj.meta.playerStateDuration = Date.now();
    }
    /** @type {!Object} */
    obj.meta.playerState = topic;
  }
  /**
   * @param {!Object} e
   * @return {undefined}
   */
  function bind(e) {
    e.meta.playbackEvents = {};
    /** @type {boolean} */
    e.meta.playbackSent = false;
    /** @type {number} */
    e.meta.playbackTracking.trackingSegment = 0;
  }
  /**
   * @param {!Object} data
   * @return {undefined}
   */
  function load(data) {
    var list;
    var key;
    var _this = data.external.playerAPI;
    var i = function(e, evt) {
      e.playlistItemData.playReason = evt.playReason || "";
      callback(e, "pa");
    }.bind(null, data);
    var ret = function(data, event) {
      var obj = data.playlistItemData.mediaId;
      if (obj && obj === $(event.item)) {
        data.playerData.lastErrorCode[id] = event.code;
        callback(data, "paf", "error");
      }
    }.bind(null, data);
    _this.on("idle buffer play pause complete error", function(typeClass) {
      debug(data, typeClass.type);
    });
    _this.on("idle", bind.bind(null, data));
    _this.on("ready", function(e) {
      /** @type {!Object} */
      data.playlistItemData.ready = merge({}, e);
      data.playerData.viewable = _this.getViewable();
    });
    _this.on("playlistItem", function(params) {
      var item = data.playlistItemData;
      /** @type {string} */
      item.drm = "";
      item.itemId = guid(12);
      data.meta.playbackTracking.playSessionSequence++;
      item.index = params.index;
      var event;
      var state;
      var rel = params.item || listener(_this);
      if (rel) {
        item.mediaId = $(rel);
        find(data, rel);
      }
      if (item.ready) {
        /** @type {!Object} */
        event = data;
        state = item.ready;
        /** @type {number} */
        event.playerData.setupTime = -1;
        if (state && state.setupTime) {
          /** @type {number} */
          event.playerData.setupTime = 10 * Math.round(state.setupTime / 10) | 0;
        }
        callback(event, "e");
        /** @type {null} */
        item.item = null;
        /** @type {null} */
        item.ready = null;
      }
      _this.off("beforePlay", i);
      _this.once("beforePlay", i);
      bind(data);
      /** @type {boolean} */
      data.meta.playbackTracking.segmentReceived = data.meta.playbackTracking.segmentsEncrypted = false;
      success(data);
    });
    _this.on("playAttemptFailed", ret);
    _this.on("meta", fetch(data, props));
    _this.on("levels", fetch(data, red));
    _this.on("play", fetch(data, req));
    _this.on("firstFrame", fetch(data, url));
    _this.on("time", function(values) {
      var someColors = data.meta.playbackEvents;
      var t = data.meta.playbackTracking;
      var result = process(_this);
      t.currentPosition = result;
      var d = values.duration;
      if (result) {
        if (1 < result) {
          if (!someColors[red]) {
            fetch(data, red)({});
          }
        }
        var _localExports;
        var found_node;
        var _name;
        var name = resolve(d);
        /** @type {(null|number)} */
        var offsetFromCenter = (_localExports = result, _name = name, (found_node = d) === 1 / 0 ? null : _localExports / (found_node / _name) + 1 | 0);
        if (0 === t.trackingSegment) {
          /** @type {(null|number)} */
          t.trackingSegment = offsetFromCenter;
        }
        if (null === t.previousTime) {
          t.previousTime = result;
        }
        /** @type {number} */
        var i = result - t.previousTime;
        if (t.previousTime = result, i = Math.min(Math.max(0, i), 4), t.playedSeconds = t.playedSeconds + i, data.playerData.viewable && (t.viewablePlayedSeconds = t.viewablePlayedSeconds + i), reducer(data, t.playedSecondsTotal, i, 10), reducer(data, t.playedSecondsTotal, i, 30), reducer(data, t.playedSecondsTotal, i, 60), t.playedSecondsTotal = t.playedSecondsTotal + i, !(d <= 0 || d === 1 / 0) && offsetFromCenter === t.trackingSegment + 1) {
          /** @type {number} */
          var startScaleIndexX = x * t.trackingSegment / name;
          if (name < offsetFromCenter) {
            return;
          }
          /** @type {number} */
          t.normalizedTime = startScaleIndexX;
          error(data, t.playedSeconds, t.viewablePlayedSeconds);
          /** @type {number} */
          t.trackingSegment = 0;
        }
      }
    });
    _this.on("seek", function(item) {
      data.meta.playbackTracking.previousTime = process(_this);
      /** @type {number} */
      data.meta.playbackTracking.trackingSegment = 0;
      render(data, item);
    });
    _this.on("seeked", function(item) {
      render(data, item, true);
    });
    _this.on("complete", function() {
      var f = data.meta.playbackTracking;
      var val = getDuration(data);
      if (!(val <= 0 || val === 1 / 0)) {
        resolve(val);
        /** @type {number} */
        f.normalizedTime = x;
        error(data, f.playedSeconds, f.viewablePlayedSeconds);
        /** @type {number} */
        f.playedSecondsTotal = 0;
      }
    });
    _this.on("cast", function(toolScope) {
      /** @type {boolean} */
      data.casting = !!toolScope.active;
    });
    _this.on("playbackRateChanged", function(media) {
      callback(data, "pru");
      data.meta.playbackTracking.prevPlaybackRate = media.playbackRate;
    });
    _this.on("visualQuality", function() {
      var image;
      var a;
      var f = H(_this);
      image = f;
      /** @type {boolean} */
      a = false;
      if (!(c.width === image.width && c.height === image.height)) {
        /** @type {boolean} */
        a = true;
      }
      c = image;
      if (a && -1 === util.indexOf(f.reason)) {
        callback(data, "vqc");
      }
    });
    _this.on(fields.join(" "), function() {
      if (data.ads.adBreakTracking) {
        /** @type {boolean} */
        data.ads.adBreakTracking.shouldTrack = true;
      }
    });
    _this.on("error", save.bind(null, data, res));
    _this.on("setupError", save.bind(null, data, app));
    _this.on("autostartNotAllowed", function() {
      callback(data, value);
    });
    _this.on("viewable", function(aboveWindow) {
      data.playerData.viewable = aboveWindow.viewable;
    });
    bind(data);
    /** @type {string} */
    key = type;
    (list = data).meta.previousBufferTimes[key] = cb(list);
  }
  /**
   * @param {!Object} options
   * @param {!Object} data
   * @return {undefined}
   */
  function parse(options, data) {
    var opts = options.ads.adEventData;
    if (-1 === options.ads.adClient && data && (options.ads.adClient = translate(data.client)), data.sequence !== opts.podIndex && (delete opts.timeAdLoading, delete opts.adCreativeType), run(opts, data, "offset"), run(opts, data, "witem"), run(opts, data, "wcount"), run(opts, data, "skipoffset"), run(opts, data, "linear", function(y, x_or_y) {
      return x_or_y === y;
    }), run(opts, data, "adposition", function(canCreateDiscussions, ballNumber) {
      return {
        pre : 0,
        mid : 1,
        post : 2,
        api : 3
      }[ballNumber];
    }), run(opts, data, "creativetype", function(canCreateDiscussions, contentType) {
      /** @type {string} */
      var type = "";
      switch(contentType) {
        case "static":
          /** @type {string} */
          type = "image/unknown";
          break;
        case "video":
          /** @type {string} */
          type = "video/unknown";
          break;
        case "vpaid":
        case "vpaid-swf":
          /** @type {string} */
          type = "application/x-shockwave-flash";
          break;
        case "vpaid-js":
          /** @type {string} */
          type = "application/javascript";
          break;
        default:
          type = contentType || type;
      }
      return opts.adCreativeType = type;
    }), run(opts, data, "tag", function(canCreateDiscussions, opt_path) {
      return opts.tagdomain = function(subTopic) {
        if (subTopic) {
          var expRecords = subTopic.match(new RegExp(/^[^/]*:\/\/\/?([^\/]*)/));
          if (expRecords && 1 < expRecords.length) {
            return expRecords[1];
          }
        }
        return "";
      }(options.external.playerAPI.utils.getAbsolutePath(opt_path)), opt_path;
    }), data.timeLoading && (opts.timeAdLoading = 10 * Math.round(data.timeLoading / 10)), data.universalAdIdRegistry && "unknown" !== data.universalAdIdRegistry ? opts.universalAdId = data.universalAdIdRegistry + "." + data.universalAdIdValue : delete opts.universalAdId, opts.conditionalAd = data.conditionalAd, opts.conditionalAdOptOut = !!data.conditionalAdOptOut, opts.mediaFileCompliance = data.mediaFileCompliance, opts.categories = data.categories, opts.adSystem = data.adsystem || opts.adSystem, 
    opts.vastVersion = data.vastversion || opts.vastVersion, opts.podIndex = data.sequence || opts.podIndex, opts.podCount = data.podcount || opts.podCount, opts.tagURL = data.tag || opts.tagURL || data.vmap, opts.preload = "boolean" == typeof data.preloadAds ? data.preloadAds : opts.preload, opts.adPlayId = data.adPlayId || opts.adPlayId, opts.adBreakId = data.adBreakId || opts.adBreakId, data.item) {
      var right = $(data.item);
      opts.targetMediaId = right != options.playlistItemData.mediaId ? right : null;
    }
    options.ads.headerBiddingData = ajaxSaveCaseExecution(data);
  }
  /**
   * @param {!Object} settings
   * @param {!Object} data
   * @param {string} key
   * @return {undefined}
   */
  function run(settings, data, key) {
    var exp = 3 < arguments.length && void 0 !== arguments[3] ? arguments[3] : exports;
    if (data.hasOwnProperty(key)) {
      var getValue = exp;
      settings[key] = getValue(key, data[key]);
    }
  }
  /**
   * @param {string} orders
   * @param {?} slug
   * @return {?}
   */
  function exports(orders, slug) {
    return slug;
  }
  /**
   * @param {!Object} data
   * @param {!Object} fn
   * @return {undefined}
   */
  function onload(data, fn) {
    var bestHeader = data.ads.adEventData;
    var headerScore = data.ads.currentQuartile;
    if (headerScore > bestHeader.previousQuartile) {
      parse(data, fn);
      callback(data, "v", "clienta");
      bestHeader.previousQuartile = headerScore;
    }
  }
  /**
   * @param {!Object} b
   * @return {undefined}
   */
  function handleResponse(b) {
    var expandel = b.external.playerAPI;
    expandel.on(drilldownLevelLabels.join(" "), function() {
      debug(b, "ad-break");
      if (b.ads.adBreakTracking && b.ads.adBreakTracking.shouldTrack) {
        /** @type {boolean} */
        b.ads.adBreakTracking.shouldTrack = false;
        b.ads.adBreakTracking.adBreakCount++;
      }
    });
    expandel.on("adClick adRequest adMeta adImpression adComplete adSkipped adError adTime adBidResponse adStarted adLoaded adViewableImpression", function(e) {
      var bid;
      var data;
      var n;
      var args = b.ads.adEventData;
      bid = args;
      if (!("adClick" === (data = e).type || bid && bid.adId === data.id && -1 !== data.id)) {
        /** @type {!Object} */
        b.ads.adEventData = merge({
          adId : e.id
        }, defaults);
      }
      /** @type {!Object} */
      n = e;
      if (-1 === unknownTypes.indexOf(n.type)) {
        parse(b, e);
      }
      if (e.type in handlers) {
        handlers[e.type](b, e);
      } else {
        if (-1 === receivedOpenEvents.indexOf(e.type)) {
          callback(b, eventsToMods[e.type], "clienta");
        }
      }
    });
  }
  /**
   * @param {!Object} p
   * @param {!Object} options
   * @return {undefined}
   */
  function handler(p, options) {
    p.related.feedId = index(options);
    p.related.feedInstanceId = expect(options);
    p.related.feedType = next(options, "kind");
    p.related.feedShownId = options.feedShownId;
    /** @type {(number|undefined)} */
    p.related.onClickSetting = "onclick" in options ? "play" === options.onclick ? 1 : 0 : void 0;
    p.related.feedInterface = options.ui;
    var pipelets = options.itemsShown || [];
    /** @type {number} */
    var n = 0;
    /** @type {!Array} */
    var block = [];
    /** @type {!Array} */
    var ret = [];
    /** @type {boolean} */
    var cb = true;
    pipelets.forEach(function(e) {
      if (method(e)) {
        n++;
      }
      block.push($(e));
      var s = replace(e, "variations.selected.images.id");
      if (s) {
        /** @type {boolean} */
        cb = false;
      }
      ret.push(s || "null");
    });
    /** @type {!Array} */
    p.related.thumbnailIdsShown = cb ? [] : ret;
    /** @type {!Array} */
    p.related.idsShown = block;
    p.related.pinnedCount = n;
    p.related.page = options.page;
    p.related.autotimerLength = options.autoTimer;
    p.related.pinSetId = method(options.target);
    p.related.advanceTarget = $(options.target);
    p.related.targetThumbID = replace(options.target, "variations.selected.images.id");
    p.related.ordinalClicked = "position" in options ? options.position + 1 : options.index;
  }
  /**
   * @param {!Object} app
   * @param {!Object} key
   * @param {string} data
   * @return {undefined}
   */
  function serialize(app, key, data) {
    handler(app, key);
    callback(app, data);
  }
  /**
   * @param {!Object} _options
   * @return {undefined}
   */
  function execute(_options) {
    _options.external.playerAPI.on("ready", function() {
      !function(item) {
        var _api = item.external.playerAPI;
        if (_api.getPlugin) {
          var element = _api.getPlugin("related");
          if (element) {
            element.on("playlist", function(options) {
              if (null !== options.playlist) {
                serialize(item, options, input);
              }
            });
            element.on("feedShown", function(context) {
              debug(item, "recs-overlay");
              item.related.shownReason = context.reason;
              item.related.feedWasViewable = context.viewable;
              serialize(item, context, part);
            });
            element.on("feedClick", function(glue) {
              serialize(item, glue, xhtml);
            });
            element.on("feedAutoAdvance", function(glue) {
              serialize(item, glue, ignore);
            });
          }
          _api.on("playlistItem", function() {
            /** @type {boolean} */
			// Farid
            // item.related.sendHoverPing = true;
            /** @type {null} */
            item.related.nextShownReason = null;
            /** @type {null} */
            item.related.shownReason = null;
          });
          _api.on("nextShown", function(context) {
            item.related.nextShownReason = context.reason;
            item.related.shownReason = context.reason;
            debug(item, "recs-overlay");
            if ("hover" !== context.reason || item.related.sendHoverPing) {
              /** @type {boolean} */
              item.related.sendHoverPing = false;
              serialize(item, context, part);
            }
          });
          _api.on("nextClick", function(glue) {
            if (item.related.nextShownReason) {
              serialize(item, glue, xhtml);
            }
          });
          _api.on("nextAutoAdvance", function(glue) {
            if (item.related.nextShownReason) {
              serialize(item, glue, ignore);
            }
          });
        }
      }(_options);
    });
  }
  /**
   * @param {!Object} options
   * @return {undefined}
   */
  function construct(options) {
    options.external.playerAPI.on("ready", function() {
      !function(b) {
        var ortc = b.external.playerAPI;
        if (ortc.getPlugin) {
          var resizeOptionsTable = ortc.getPlugin("sharing");
          if (resizeOptionsTable) {
            resizeOptionsTable.on("click", function(rule) {
              b.sharing.shareMethod = types[rule.method] || types.custom;
              callback(b, p);
            });
          }
        }
      }(options);
    });
  }
  /**
   * @param {!Object} hit
   * @return {undefined}
   */
  function listen(hit) {
    var result;
    var stop;
    if ("function" == typeof navigator.sendBeacon) {
      /** @type {!Object} */
      result = hit;
      /**
       * @return {undefined}
       */
      stop = function() {
        var url = callback(result, y, "jwplayer6", {
          returnURL : true
        });
        if (void 0 !== url) {
          navigator.sendBeacon(url);
        }
      };
      window.addEventListener("unload", stop);
      result.external.playerAPI.on("remove", function() {
        window.removeEventListener("unload", stop);
        /** @type {boolean} */
        result.meta.playerRemoved = true;
        callback(result, y, "jwplayer6");
      });
    }
  }
  /** @type {number} */
  var invalid = 4;
  var test = {
    pro : 1,
    premium : 2,
    ads : 3,
    invalid : invalid,
    enterprise : 6,
    trial : 7,
    platinum : 8,
    starter : 9,
    business : 10,
    developer : 11
  };
  var eventItem = {
    viewable : 2
  };
  /** @type {string} */
  var currentRelations = "DATA_EVENT_PLAY";
  /** @type {string} */
  var prop = "DATA_EVENT_META";
  /** @type {string} */
  var NaN = "DATA_EVENT_LEVELS";
  /** @type {string} */
  var o = "DATA_EVENT_FIRST_FRAME";
  /** @type {number} */
  var x = 128;
  /** @type {!Array} */
  var util = ["auto", "initial choice"];
  /** @type {!Array} */
  var fields = ["playlistItem", "playAttempt", "time", "adBreakEnd"];
  /** @type {string} */
  var event = "error";
  /** @type {string} */
  var value = "ana";
  /** @type {string} */
  var type = "t";
  /** @type {string} */
  var p = "vsh";
  /** @type {string} */
  var id = "paf";
  /** @type {string} */
  var input = "bs";
  /** @type {string} */
  var part = "fs";
  /** @type {string} */
  var xhtml = "fc";
  /** @type {string} */
  var ignore = "aa";
  /** @type {string} */
  var y = "gab";
  /** @type {string} */
  var i = "ph";
  /** @type {string} */
  var arr = "n";
  /** @type {string} */
  var err = "e";
  /** @type {string} */
  var file = "sa";
  /** @type {string} */
  var end = "i";
  /** @type {string} */
  var AS = "as";
  /** @type {string} */
  var sustain = "ar";
  /** @type {string} */
  var app = "ers";
  /** @type {string} */
  var res = "err";
  var raw_modified;
  /** @type {function(): ?} */
  var slideBackward = (raw_modified = function() {
    /** @type {!PluginArray} */
    var plugins = navigator.plugins;
    if (plugins && "object" == typeof plugins["Shockwave Flash"]) {
      /** @type {string} */
      var workshopDesc = plugins["Shockwave Flash"].description;
      if (workshopDesc) {
        return workshopDesc;
      }
    }
    if (void 0 !== window.ActiveXObject) {
      try {
        var t = new window.ActiveXObject("ShockwaveFlash.ShockwaveFlash");
        if (t) {
          var d = t.GetVariable("$version");
          if (d) {
            return d;
          }
        }
      } catch (e) {
      }
    }
    return "";
  }().replace(/\D+(\d+\.?\d*).*/, "$1"), function() {
    return raw_modified;
  });
  var $uniqueId = guid(12);
  var storage = void 0;
  try {
    /** @type {(Storage|null)} */
    storage = window.localStorage;
  } catch (e) {
  }
  /** @type {function(): ?} */
  var $at = "hidden" in document ? function() {
    return !document.hidden;
  } : "webkitHidden" in document ? function() {
    return !document.webkitHidden;
  } : function() {
    return true;
  };
  /** @type {string} */
  var name = prop;
  var c = void 0;
  var Modes = {
    UNKNOWN : 999,
    IAB : 0
  };
  var args = {
    noBid : 0,
    bid : 1,
    timeout : 2,
    invalid : 3,
    abort : 4,
    error : 5
  };
  var defaults = {
    numCompanions : -1,
    podCount : 0,
    podIndex : 0,
    linear : -1,
    vastVersion : -1,
    adSystem : null,
    adCreativeType : null,
    adposition : -1,
    tagdomain : null,
    position : void 0,
    previousQuartile : 0,
    duration : void 0,
    witem : 1,
    wcount : 1,
    preload : void 0,
    adMediaFileURL : void 0
  };
  /** @type {!RegExp} */
  var rDataName = /^IAB(\d+(?:-\d+)?)$/;
  var eventsToMods = {
    adRequest : "ar",
    adImpression : "i",
    adSkipped : "s",
    adError : "ae",
    adBidResponse : "abr",
    adStarted : "as",
    adClick : "c",
    adLoaded : "al",
    adViewableImpression : "vi"
  };
  /** @type {!Array} */
  var receivedOpenEvents = ["adMeta"];
  /** @type {!Array} */
  var unknownTypes = ["adTime", "adClick", "adStarted"];
  /** @type {!Array} */
  var drilldownLevelLabels = ["adBreakStart", "adMeta", "adStarted", "adImpression", "adViewableImpression", "adPlay", "adPause", "adTime", "adCompanions", "adClick", "adSkipped", "adComplete", "adError"];
  var generatedSlugs = {
    dfp : 0,
    jwp : 1,
    jwpdfp : 2,
    jwpspotx : 3
  };
  /** @type {!Array} */
  var values = ["1", "yes", "true"];
  /** @type {string} */
  var TEXT_SIZE_CONTAINER_ID = "jwp-global-frame";
  /** @type {string} */
  var oe = "i.jwpsrv.com";
  var formats = {
    PARAM_ANALYTICS_TOKEN : "aid",
    PARAM_MEDIA_ID : "id",
    EMBED_ID : "emi",
    ITEM_ID : "pli",
    PARAM_EXTERNAL_ID : "xid",
    PARAM_XID_ALGORITHM_VERSION : "xav",
    PARAM_PLAYER_VERSION : "pv",
    PARAM_TRACKER_VERSION : "tv"
  };
  /** @type {function(!Object, ...(Object|null)): !Object} */
  var merge = Object.assign || function() {
    /** @type {number} */
    var _len8 = arguments.length;
    /** @type {!Array} */
    var storeNames = Array(_len8);
    /** @type {number} */
    var _key8 = 0;
    for (; _key8 < _len8; _key8++) {
      storeNames[_key8] = arguments[_key8];
    }
    return Array.prototype.slice.call(arguments, 0).reduce(function(sNext, dNext) {
      return s = sNext, d = dNext, Object.keys(d).forEach(function(i) {
        s[i] = d[i];
      }), s;
      var s;
      var d;
    }, {});
  };
  /** @type {number} */
  var ha = 0;
  var Ie = {
    sgB1CN8sEeW9HgpVuA4vVw : false,
    "QHh6WglVEeWjwQp+lcGdIw" : true,
    "4lTGrhE9EeWepAp+lcGdIw" : true,
    "98DmWsGzEeSdAQ4AfQhyIQ" : true,
    "xNaEVFs+Eea6EAY3v_uBow" : true,
    KvvTdq_lEeSqTw4AfQhyIQ : false
  };
  /** @type {number} */
  var k = 1;
  var socket = {
    events : {
      "aa-jwplayer6" : {
        code : "aa",
        bucket : "jwplayer6",
        parameterGroups : ["global"],
        pingSpecificParameters : ["fct", "fed", "fid", "fin", "fns", "fsid", "fsr", "ft", "mu", "os", "psd"],
        filters : ["missingFeedID"]
      },
      "abr-clienta" : {
        code : "abr",
        bucket : "clienta",
        parameterGroups : ["global", "adGlobal", "headerBidding"],
        pingSpecificParameters : []
      },
      "ae-clienta" : {
        code : "ae",
        bucket : "clienta",
        parameterGroups : ["global", "adGlobal", "headerBidding"],
        pingSpecificParameters : ["apr", "atu", "ca", "cao", "ec", "ad", "aec", "ct", "mfc", "uav"],
        filters : ["missingAdScheduleID"]
      },
      "al-clienta" : {
        code : "al",
        bucket : "clienta",
        parameterGroups : ["global", "adGlobal"],
        pingSpecificParameters : ["tal"],
        filters : ["missingAdScheduleID"]
      },
      "ana-jwplayer6" : {
        code : "ana",
        bucket : "jwplayer6",
        parameterGroups : ["sessionParamsOnly"],
        pingSpecificParameters : [],
        filters : ["missingMediaOrExternalID"]
      },
      "ar-clienta" : {
        code : "ar",
        bucket : "clienta",
        parameterGroups : ["global", "adGlobal"],
        pingSpecificParameters : ["apr"],
        filters : ["missingAdScheduleID"]
      },
      "as-clienta" : {
        code : "as",
        bucket : "clienta",
        parameterGroups : ["global", "adGlobal"],
        pingSpecificParameters : ["ad", "adc", "al", "ct", "fed", "fid", "psd", "tal", "vv", "uav"]
      },
      "bs-jwplayer6" : {
        code : "bs",
        bucket : "jwplayer6",
        parameterGroups : ["global"],
        pingSpecificParameters : ["fed", "fid", "ft", "mu", "os"],
        filters : ["missingFeedID"]
      },
      "c-clienta" : {
        code : "c",
        bucket : "clienta",
        parameterGroups : ["global", "adGlobal"],
        pingSpecificParameters : ["ad", "adc", "al", "ct", "du", "qt", "srf", "tw", "vv", "uav"]
      },
      "e-jwplayer6" : {
        code : "e",
        bucket : "jwplayer6",
        parameterGroups : ["global"],
        pingSpecificParameters : ["ab", "cb", "cme", "dd", "dnt", "fv", "ga", "lng", "mk", "mu", "pad", "pbc", "pd", "pdr", "plng", "plt", "pni", "pnl", "po", "pogt", "ptid", "r", "rf", "sn", "sp", "srf", "st", "vp", "vrt"]
      },
      "err-error" : {
        code : "err",
        bucket : "error",
        parameterGroups : ["global"],
        pingSpecificParameters : ["cme", "erc", "pogt"]
      },
      "ers-error" : {
        code : "ers",
        bucket : "error",
        parameterGroups : ["global"],
        pingSpecificParameters : ["cme", "erc", "pogt"]
      },
      "fc-jwplayer6" : {
        code : "fc",
        bucket : "jwplayer6",
        parameterGroups : ["global"],
        pingSpecificParameters : ["fct", "fed", "fid", "fin", "fns", "fpg", "fsid", "fsr", "ft", "mu", "oc", "os", "psd", "srf", "stid"],
        filters : ["missingFeedID"]
      },
      "fs-jwplayer6" : {
        code : "fs",
        bucket : "jwplayer6",
        parameterGroups : ["global"],
        pingSpecificParameters : ["fed", "fid", "fin", "fis", "fns", "fpc", "fpg", "fsid", "fsr", "ft", "mu", "os", "rat", "srf", "tis", "vfi"],
        filters : ["missingFeedID"]
      },
      "gab-jwplayer6" : {
        code : "gab",
        bucket : "jwplayer6",
        parameterGroups : ["global"],
        pingSpecificParameters : ["abid", "abpr", "apid", "erc", "lae", "pcp", "prs", "prsd", "srf", "ti", "tps", "ubc", "vti"],
        filters : ["missingMediaOrExternalID"]
      },
      "i-clienta" : {
        code : "i",
        bucket : "clienta",
        parameterGroups : ["global", "adGlobal", "headerBidding"],
        pingSpecificParameters : ["ad", "apr", "adc", "adt", "al", "amu", "ca", "cao", "cid", "ct", "du", "fed", "fid", "mfc", "psd", "tal", "vv", "uav"]
      },
      "idt-g" : {
        code : "idt",
        bucket : "g",
        parameterGroups : ["sessionParamsOnly"],
        pingSpecificParameters : ["gid"],
        filters : ["missingMediaOrExternalID"]
      },
      "pa-jwplayer6" : {
        code : "pa",
        bucket : "jwplayer6",
        parameterGroups : ["global"],
        pingSpecificParameters : ["ab", "abid", "abm", "apid", "bwe", "cme", "dnt", "fed", "fid", "lng", "mu", "pd", "pdr", "plng", "pni", "pnl", "pogt", "pr", "psd", "sbr", "tb", "vd", "vh", "vw"],
        filters : ["missingMediaOrExternalID"]
      },
      "paf-error" : {
        code : "paf",
        bucket : "error",
        parameterGroups : ["global"],
        pingSpecificParameters : ["abm", "bwe", "erc", "fed", "fid", "mu", "pd", "pr", "psd", "sbr", "tb", "vd", "vh", "vw"],
        filters : ["missingMediaOrExternalID"]
      },
      "pru-jwplayer6" : {
        code : "pru",
        bucket : "jwplayer6",
        parameterGroups : ["global"],
        pingSpecificParameters : ["ppr"],
        filters : ["missingMediaOrExternalID"]
      },
      "ret-jwplayer6" : {
        code : "ret",
        bucket : "jwplayer6",
        parameterGroups : ["global"],
        pingSpecificParameters : ["abm", "bwe", "etw", "fed", "fid", "mu", "pr", "q", "sbr", "srf", "ubc", "vh", "vr", "vti", "vw"],
        filters : ["missingMediaOrExternalID"]
      },
      "s-jwplayer6" : {
        code : "s",
        bucket : "jwplayer6",
        parameterGroups : ["global"],
        pingSpecificParameters : ["abid", "abm", "apid", "bwe", "cct", "dnt", "drm", "fed", "ff", "fid", "l", "lng", "mk", "mu", "pd", "pdr", "plng", "pni", "pnl", "pr", "psd", "q", "qcr", "sbr", "sp", "srf", "tb", "tt", "vd", "vh", "vs", "vrt", "vr", "vw"]
      },
      "s-clienta" : {
        code : "s",
        bucket : "clienta",
        parameterGroups : ["global", "adGlobal"],
        pingSpecificParameters : ["ad", "adc", "al", "atps", "ct", "du", "qt", "tw", "vv", "uav"]
      },
      "t-jwplayer6" : {
        code : "t",
        bucket : "jwplayer6",
        parameterGroups : ["global"],
        pingSpecificParameters : ["abm", "bwe", "fed", "fid", "mu", "pcp", "pw", "q", "sbr", "ti", "ubi", "vh", "vr", "vti", "vw"],
        filters : ["missingMediaOrExternalID"]
      },
      "v-clienta" : {
        code : "v",
        bucket : "clienta",
        parameterGroups : ["global", "adGlobal"],
        pingSpecificParameters : ["ad", "adc", "al", "ct", "du", "qt", "vv", "uav"],
        filters : ["missingAdScheduleID", "missingAdDuration"]
      },
      "vi-clienta" : {
        code : "vi",
        bucket : "clienta",
        parameterGroups : ["global", "adGlobal"],
        filters : ["missingAdScheduleID"]
      },
      "vqc-jwplayer6" : {
        code : "vqc",
        bucket : "jwplayer6",
        parameterGroups : ["global"],
        pingSpecificParameters : ["abm", "bwe", "qcr", "sbr", "tb", "vw", "vh"],
        filters : ["missingMediaOrExternalID"]
      },
      "vs-jwplayer6" : {
        code : "vs",
        bucket : "jwplayer6",
        parameterGroups : ["global"],
        pingSpecificParameters : ["cvl", "sdt", "tvl", "vso"],
        filters : ["missingMediaOrExternalID"]
      },
      "vsh-jwplayer6" : {
        code : "vsh",
        bucket : "jwplayer6",
        parameterGroups : ["global"],
        pingSpecificParameters : ["pcp", "srf", "stg"],
        filters : ["missingMediaOrExternalID"]
      }
    },
    paramGroups : {
      global : {
        members : ["abc", "abt", "aid", "ask", "at", "c", "ccp", "cp", "d", "eb", "ed", "emi", "i", "id", "lid", "lsa", "mt", "pbd", "pbr", "pgi", "ph", "pid", "pii", "pl", "plc", "pli", "pp", "prc", "ps", "pss", "pt", "pu", "pv", "pyc", "s", "sdk", "set", "stc", "sv", "t", "tul", "tv", "tvs", "vb", "vi", "vl", "wd", "xav", "xid"],
        groupName : "global"
      },
      adGlobal : {
        members : ["ab", "abid", "abo", "adi", "apid", "awi", "awc", "p", "pc", "pi", "sko", "tmid", "vu"],
        groupName : "adGlobal"
      },
      sessionParamsOnly : {
        members : ["aid", "emi", "id", "pli", "pv", "tv", "xav", "xid"],
        groupName : "sessionParamsOnly"
      },
      headerBidding : {
        members : ["afbb", "afbi", "afbp", "afbt", "afbw", "aml", "asxb", "asxi", "asxp", "asxt", "asxw", "flpc"],
        groupName : "headerBidding"
      }
    }
  };
  var scales = {
    missingMediaOrExternalID : function(value) {
      return !value.playlistItemData.mediaId && !value.playlistItemData.externalId;
    },
    missingAdScheduleID : function(result) {
      return !result.ads.adScheduleId;
    },
    missingAdDuration : function(result) {
      return !result.ads.adEventData.duration;
    },
    missingFeedID : function(p) {
      return !p.related.feedId;
    }
  };
  var data = {
    abc : function(result) {
      var a = result.ads.adBreakTracking;
      if (a) {
        return a.adBreakCount;
      }
    },
    abt : function(doc_query) {
      var e = doc_query.external.playerAPI.getConfig();
      var suite = e.ab;
      if (suite && suite.tests) {
        return Object.keys(suite.tests).map(function(component) {
          return suite.getSelected(component, e).join(",");
        }).filter(function(canCreateDiscussions) {
          return canCreateDiscussions;
        }).join(",");
      }
    },
    aid : function(savedSync) {
      return savedSync.accountData.analyticsID;
    },
    ask : function(options) {
      return options.ads.adScheduleId;
    },
    at : function(time24hr) {
      return $at();
    },
    c : function(data) {
      return data.ads.adClient;
    },
    ccp : function(options) {
      return options.casting;
    },
    cp : function(options) {
      return !options.external.playerAPI.getControls();
    },
    d : function(opts) {
      return opts.configData.autostartConfig;
    },
    eb : function(doc_query) {
      return (a = doc_query.external.playerAPI).getAdBlock ? a.getAdBlock() : -1;
      var a;
    },
    ed : function(s) {
      return s.accountData.edition;
    },
    emi : function(canCreateDiscussions) {
      return canCreateDiscussions.staticPlayerData.embedID;
    },
    i : function(data) {
      return data.browser.pageData.inIframe;
    },
    id : function(value) {
      return value.playlistItemData.mediaId;
    },
    lid : function(options) {
      return options.browser.storage.localID;
    },
    lsa : function(options) {
      return options.browser.storage.storageAvailable;
    },
    mt : function(callback) {
      return callback.external.playerAPI.getMute();
    },
    mu : function(state) {
      return function(data, newPath) {
        var dir = void 0;
        if (!data) {
          return null;
        }
        var sources = data.sources;
        if (sources) {
          /** @type {!Array} */
          var args = [];
          var i = sources.length;
          for (; i--;) {
            if (sources[i].file) {
              args.push(sources[i].file);
            }
          }
          args.sort();
          dir = args[0];
        } else {
          dir = data.file;
        }
        return newPath.getAbsolutePath(dir);
      }(state.playlistItemData.item, state.external.utils);
    },
    pbd : function(self) {
      return self.playerData.defaultPlaybackRate;
    }
  };
  /**
   * @param {!Window} doc_query
   * @return {?}
   */
  data.pbr = function(doc_query) {
    return (videoModel = doc_query.external.playerAPI).getPlaybackRate ? Math.round(100 * videoModel.getPlaybackRate()) / 100 : 1;
    var videoModel;
  };
  /**
   * @param {?} data
   * @return {?}
   */
  data.pgi = function(data) {
    return data.browser.pageData.pageViewId;
  };
  /**
   * @param {?} api
   * @return {?}
   */
  data[i] = function(api) {
    return api.configData.playerHosting;
  };
  /**
   * @param {?} state
   * @return {?}
   */
  data.pid = function(state) {
    return state.configData.playerConfigKey;
  };
  /**
   * @param {?} addEntry
   * @return {?}
   */
  data.pii = function(addEntry) {
    return addEntry.playlistItemData.index;
  };
  /**
   * @param {?} n
   * @return {?}
   */
  data.pl = function(n) {
    return n.playerData.playerSize.height;
  };
  /**
   * @param {!Window} doc_query
   * @return {?}
   */
  data.plc = function(doc_query) {
    return doc_query.external.playerAPI.getPlaylist().length;
  };
  /**
   * @param {?} data
   * @return {?}
   */
  data.pli = function(data) {
    return data.playlistItemData.itemId;
  };
  /**
   * @param {!Window} state
   * @return {?}
   */
  data.pp = function(state) {
    return stringify(state.external.playerAPI);
  };
  /**
   * @param {?} canCreateDiscussions
   * @return {?}
   */
  data.prc = function(canCreateDiscussions) {
    return function() {
      var a = window.jwplayer;
      /** @type {number} */
      var anchor = 0;
      if ("function" == typeof a) {
        /** @type {number} */
        anchor = 0;
        for (; anchor < 1E3; anchor++) {
          if (!a(anchor).uniqueId) {
            return anchor;
          }
        }
      }
      return anchor;
    }();
  };
  /**
   * @param {?} message
   * @return {?}
   */
  data.ps = function(message) {
    return message.playerData.playerSize.bucket;
  };
  /**
   * @param {!Object} appUriData
   * @return {?}
   */
  data.pss = function(appUriData) {
    return appUriData.meta.playbackTracking.playSessionSequence;
  };
  /**
   * @param {?} data
   * @return {?}
   */
  data.pt = function(data) {
    return data.browser.pageData.pageTitle;
  };
  /**
   * @param {?} data
   * @return {?}
   */
  data.pu = function(data) {
    return data.browser.pageData.pageURL;
  };
  /**
   * @param {?} options
   * @return {?}
   */
  data.pv = function(options) {
    return options.staticPlayerData.playerVersion;
  };
  /**
   * @param {!Object} appUriData
   * @return {?}
   */
  data.pyc = function(appUriData) {
    return appUriData.meta.playbackTracking.playItemCount;
  };
  /**
   * @param {?} o
   * @return {?}
   */
  data.s = function(o) {
    return o.configData.sharingEnabled;
  };
  /**
   * @param {?} callback
   * @return {?}
   */
  data.sdk = function(callback) {
    return callback.staticPlayerData.sdkPlatform;
  };
  /**
   * @param {?} e
   * @return {?}
   */
  data.set = function(e) {
    return e.playlistItemData.item.set;
  };
  /**
   * @param {!Object} appUriData
   * @return {?}
   */
  data.stc = function(appUriData) {
    return appUriData.meta.setupCount;
  };
  /**
   * @param {?} platform
   * @return {?}
   */
  data.sv = function(platform) {
    return platform.staticPlayerData.sdkVersion;
  };
  /**
   * @param {?} a
   * @return {?}
   */
  data.t = function(a) {
    return compile(a.playlistItemData.item);
  };
  /**
   * @param {?} dragZone
   * @return {?}
   */
  data.tul = function(dragZone) {
    return dragZone.playlistItemData.item.thumbnailUrl;
  };
  /**
   * @param {?} options
   * @return {?}
   */
  data.tv = function(options) {
    return "3.5.5";
  };
  /**
   * @param {?} dragZone
   * @return {?}
   */
  data.tvs = function(dragZone) {
    return dragZone.playlistItemData.item.tvs || 0;
  };
  /**
   * @param {?} level5
   * @return {?}
   */
  data.vb = function(level5) {
    return level5.playerData.viewable;
  };
  /**
   * @param {?} n
   * @return {?}
   */
  data.vi = function(n) {
    var value = n.playerData.playerConfig.visibility;
    return void 0 === value ? value : Math.round(100 * value) / 100;
  };
  /**
   * @param {!Window} context
   * @return {?}
   */
  data.vl = function(context) {
    return context.external.playerAPI.getVolume();
  };
  /**
   * @param {?} level5
   * @return {?}
   */
  data.wd = function(level5) {
    return level5.playerData.playerSize.width;
  };
  /**
   * @param {?} xid
   * @return {?}
   */
  data.xid = function(xid) {
    return xid.playlistItemData.externalId;
  };
  /**
   * @param {!Object} appUriData
   * @return {?}
   */
  data.xav = function(appUriData) {
    return appUriData.meta.xidAlgorithmVersion;
  };
  var val = {
    cb : function(self) {
      return self.configData.castingBlockPresent;
    },
    dd : function(format) {
      return format.configData.displayDescription;
    },
    ga : function(a) {
      return a.configData.gaBlockPresent;
    },
    pad : function(sideToPad) {
      return sideToPad.configData.abTestConfig;
    },
    pbc : function(api) {
      return api.configData.playbackRateControlsSet;
    },
    po : function(o) {
      return o.configData.posterImagePresent;
    },
    r : function(o) {
      return o.configData.relatedPluginConfigPresent;
    },
    rf : function(val) {
      return val.configData.relatedPluginFeedFile;
    },
    sn : function(data) {
      return data.configData.skinName;
    },
    vp : function(name) {
      return name.configData.visualPlaylist;
    }
  };
  var params = {
    dnt : function(options) {
      return options.browser.storage.doNotTrackProperty;
    },
    fv : function(data) {
      return data.browser.pageData.flashVersion;
    },
    lng : function(data) {
      return data.browser.langAttr;
    },
    pdr : function(videojs) {
      return videojs.browser.docReferrer;
    }
  };
  /**
   * @param {?} canCreateDiscussions
   * @return {?}
   */
  params.plt = function(canCreateDiscussions) {
    return function() {
      /** @type {(PerformanceTiming|null)} */
      var timing = (window.performance || {}).timing;
      if (timing) {
        /** @type {number} */
        var filmSteps = (timing.loadEventEnd || (new Date).getTime()) - timing.navigationStart;
        if (0 < filmSteps) {
          return 50 * Math.round(filmSteps / 50) | 0;
        }
      }
      return null;
    }();
  };
  /**
   * @param {?} s
   * @return {?}
   */
  params.sp = function(s) {
    return s.browser.isPageStandalone;
  };
  var nextIdLookup = {
    aes : 1,
    widevine : 2,
    playready : 3,
    fairplay : 4
  };
  var options = {
    interaction : 1,
    autostart : 2,
    repeat : 3,
    external : 4,
    "related-interaction" : 1,
    "related-auto" : 5,
    playlist : 6
  };
  var _overwriteLookup = {
    none : 1,
    metadata : 2,
    auto : 3
  };
  /** @type {!Array} */
  var arrayKey = [ignore, input, xhtml, part];
  /** @type {string} */
  var tmpx = NaN;
  /** @type {string} */
  var signedTransactionsCounter = prop;
  var config = {};
  /**
   * @param {!Window} state
   * @return {?}
   */
  config.mk = function(state) {
    return function(billData, job) {
      if (!billData) {
        return null;
      }
      var change = billData.sources[0];
      var type = change.type;
      if (!type) {
        var file = change.file;
        type = job.extension(file);
      }
      return type;
    }(state.playlistItemData.item, state.external.utils);
  };
  /**
   * @param {?} spec
   * @return {?}
   */
  config.pd = function(spec) {
    return item = spec.playlistItemData.item, value = item.preload, _overwriteLookup[value] || 0;
    var item;
    var value;
  };
  /**
   * @param {?} dragZone
   * @return {?}
   */
  config.vrt = function(dragZone) {
    return function(ro) {
      if (!ro || !ro.stereomode) {
        return null;
      }
      switch(ro.stereomode) {
        case "monoscopic":
          return 0;
        case "stereoscopicTopBottom":
          return 1;
        case "stereoscopicLeftRight":
          return 2;
        default:
          return null;
      }
    }(dragZone.playlistItemData.item);
  };
  /**
   * @param {?} context
   * @return {?}
   */
  config.pr = function(context) {
    return __testDataKey = context.playlistItemData.playReason, options[__testDataKey] || 0;
    var __testDataKey;
  };
  /**
   * @param {!Object} data
   * @return {?}
   */
  config.psd = function(data) {
    return -1 !== arrayKey.indexOf(data.meta.lastEvent) ? data.related.pinSetId : method(data.playlistItemData.item);
  };
  /**
   * @param {?} value
   * @return {?}
   */
  config.vh = function(value) {
    return value.playerData.visualQuality.height;
  };
  /**
   * @param {?} value
   * @return {?}
   */
  config.vw = function(value) {
    return value.playerData.visualQuality.width;
  };
  /**
   * @param {?} level5
   * @return {?}
   */
  config.sbr = function(level5) {
    return level5.playerData.visualQuality.bitrate;
  };
  /**
   * @param {!Window} opt
   * @return {?}
   */
  config.tb = function(opt) {
    return function(context) {
      var data = context.getContainer().querySelector("video");
      /** @type {number} */
      var currentDuration = 0;
      if (data && (currentDuration = data.duration, data.buffered && data.buffered.length)) {
        var ipw = data.buffered.end(data.buffered.length - 1) || 0;
        return Math.round(10 * ipw) / 10;
      }
      return currentDuration || (currentDuration = Math.abs(context.getDuration())), Math.round(currentDuration * context.getBuffer() / 10) / 10;
    }(opt.external.playerAPI);
  };
  /**
   * @param {?} v
   * @return {?}
   */
  config.vd = function(v) {
    return v.playlistItemData.duration;
  };
  /**
   * @param {?} options
   * @return {?}
   */
  config.q = function(options) {
    return resolve(options.playlistItemData.duration);
  };
  /**
   * @param {?} context
   * @return {?}
   */
  config.tt = function(context) {
    return item = context.playlistItemData.item, arr = item.tracks, Array.prototype.some.call(arr || 0, function(mobValue) {
      return "thumbnails" === mobValue.kind;
    });
    var item;
    var arr;
  };
  /**
   * @param {!Object} options
   * @return {?}
   */
  config.vs = function(options) {
    var signedTransactions = options.meta.playbackEvents;
    return function(result, billData, options) {
      var cssChanges = 3 < arguments.length && void 0 !== arguments[3] ? arguments[3] : {};
      if (!billData) {
        return null;
      }
      if (options && options.levels && options.levels.length) {
        var rendLeg = options.levels[0];
        if (rendLeg && "auto" === ("" + rendLeg.label).toLowerCase()) {
          return 5;
        }
      }
      if (f(result.getContainer(), "jw-flag-audio-player")) {
        return 6;
      }
      /** @type {number} */
      var i = 0 | cssChanges.width;
      /** @type {number} */
      var j = 0 | cssChanges.height;
      return 0 === i && 0 === j ? "rtmp" === billData.sources[0].type ? 6 : 0 : i <= 320 ? 1 : i <= 640 ? 2 : i <= 1280 ? 3 : 4;
    }(options.external.playerAPI, options.playlistItemData.item, signedTransactions[tmpx], signedTransactions[signedTransactionsCounter]);
  };
  /**
   * @param {?} dragZone
   * @return {?}
   */
  config.ptid = function(dragZone) {
    return replace(dragZone.playlistItemData.item, "variations.selected.images.id");
  };
  /** @type {function(?): number} */
  var r = Math.round;
  var result = {
    st : function(object) {
      return object.playerData.setupTime;
    }
  };
  /**
   * @param {?} level5
   * @return {?}
   */
  result.bwe = function(level5) {
    return createElement(level5.playerData.playerConfig.bandwidthEstimate);
  };
  /**
   * @param {!Window} info
   * @return {?}
   */
  result.cct = function(info) {
    return data = info.playlistItemData.item, api = info.external.playerAPI, Array.prototype.some.call(data.tracks || 0, function(mobValue) {
      var undefined = mobValue.kind;
      return "captions" === undefined || "subtitles" === undefined;
    }) ? 1 : 1 < api.getCaptionsList().length ? 2 : 0;
    var data;
    var api;
  };
  /**
   * @param {!Object} appUriData
   * @return {?}
   */
  result.drm = function(appUriData) {
    return ((indexLookupKey = appUriData.playlistItemData.drm) ? nextIdLookup[indexLookupKey] || 999 : 0) || appUriData.meta.playbackTracking.segmentsEncrypted;
    var indexLookupKey;
  };
  /**
   * @param {!Window} b
   * @return {?}
   */
  result.ff = function(b) {
    return "function" == typeof(api = b.external.playerAPI).qoe ? 10 * Math.round(api.qoe().firstFrame / 10) | 0 : -1;
    var api;
  };
  /**
   * @param {?} a
   * @return {?}
   */
  result.l = function(a) {
    return end = a.playlistItemData.duration, (end = end | 0) <= 0 || end === 1 / 0 ? 0 : end < 15 ? 1 : end <= 300 ? 2 : end <= 1200 ? 3 : 4;
    var end;
  };
  /**
   * @param {!Window} doc_query
   * @return {?}
   */
  result.vr = function(doc_query) {
    return function(tangelo) {
      if (tangelo.getPlugin) {
        var modifiedModel = tangelo.getPlugin("vr");
        if (modifiedModel) {
          switch(modifiedModel.getMode()) {
            case "magic-window":
              return 0;
            case "cardboard":
              return 1;
            case "gear-vr":
              return 2;
            default:
              return null;
          }
        }
      }
      return null;
    }(doc_query.external.playerAPI);
  };
  /**
   * @param {!Object} appUriData
   * @return {?}
   */
  result.etw = function(appUriData) {
    return appUriData.meta.playbackTracking.retTimeWatched;
  };
  /**
   * @param {!Object} undefined
   * @return {?}
   */
  result.ubc = function(undefined) {
    return r(cb(undefined));
  };
  /**
   * @param {!Object} e
   * @return {?}
   */
  result.ubi = function(e) {
    return r(function(instance, full_key) {
      if (void 0 === full_key) {
        full_key = instance.meta.lastEvent;
      }
      var value = cb(instance);
      var result = instance.meta.previousBufferTimes[full_key];
      if (void 0 === instance.meta.previousBufferTimes[full_key]) {
        result = instance.meta.previousBufferTimes[full_key] = value;
      }
      /** @type {number} */
      var elem = Math.round(value - result);
      return instance.meta.previousBufferTimes[full_key] = value, elem;
    }(e));
  };
  /**
   * @param {!Object} msg
   * @return {?}
   */
  result.pw = function(msg) {
    return 0 | msg.meta.playbackTracking.normalizedTime;
  };
  /**
   * @param {!Object} appUriData
   * @return {?}
   */
  result.ti = function(appUriData) {
    return appUriData.meta.playbackTracking.elapsedSeconds;
  };
  /**
   * @param {!Object} appUriData
   * @return {?}
   */
  result.vti = function(appUriData) {
    return appUriData.meta.playbackTracking.viewableElapsedSeconds;
  };
  /**
   * @param {!Object} appUriData
   * @return {?}
   */
  result.cvl = function(appUriData) {
    return Math.floor(appUriData.meta.seekTracking.videoStartDragTime);
  };
  /**
   * @param {!Object} appUriData
   * @return {?}
   */
  result.tvl = function(appUriData) {
    return Math.floor(appUriData.meta.seekTracking.lastTargetTime);
  };
  /**
   * @param {!Object} appUriData
   * @return {?}
   */
  result.sdt = function(appUriData) {
    return 1 === appUriData.meta.seekTracking.numTrackedSeeks ? 0 : Date.now() - appUriData.meta.seekTracking.dragStartTime;
  };
  /**
   * @param {!Object} appUriData
   * @return {?}
   */
  result.vso = function(appUriData) {
    return Math.floor(appUriData.meta.seekTracking.lastTargetTime) - Math.floor(appUriData.meta.seekTracking.videoStartDragTime);
  };
  /**
   * @param {?} level5
   * @return {?}
   */
  result.qcr = function(level5) {
    return level5.playerData.visualQuality.reason;
  };
  /**
   * @param {!Object} v
   * @return {?}
   */
  result.ppr = function(v) {
    return v.meta.playbackTracking.prevPlaybackRate;
  };
  /**
   * @param {!Object} data
   * @return {?}
   */
  result.erc = function(data) {
    return data.playerData.lastErrorCode[data.meta.lastEvent];
  };
  /**
   * @param {!Object} appUriData
   * @return {?}
   */
  result.pcp = function(appUriData) {
    return r(appUriData.meta.playbackTracking.currentPosition);
  };
  /**
   * @param {!Object} state
   * @return {?}
   */
  result.stg = function(state) {
    return state.sharing.shareMethod;
  };
  /**
   * @param {?} level5
   * @return {?}
   */
  result.abm = function(level5) {
    return level5.playerData.visualQuality.adaptiveBitrateMode;
  };
  /**
   * @param {!Object} appUriData
   * @return {?}
   */
  result.tps = function(appUriData) {
    return r(appUriData.meta.playbackTracking.playedSecondsTotal);
  };
  /**
   * @param {!Object} state
   * @return {?}
   */
  result.srf = function(state) {
    return state.sharing.shareReferrer;
  };
  /**
   * @param {?} context
   * @return {?}
   */
  result.plng = function(context) {
    return context.playerData.localization.language;
  };
  /**
   * @param {?} context
   * @return {?}
   */
  result.pni = function(context) {
    return context.playerData.localization.numIntlKeys;
  };
  /**
   * @param {?} context
   * @return {?}
   */
  result.pnl = function(context) {
    return context.playerData.localization.numLocalKeys;
  };
  var status = {
    fed : function(p) {
      return -1 !== arrayKey.indexOf(p.meta.lastEvent) ? p.related.feedId : index(p.playlistItemData.item);
    },
    fid : function(data) {
      return -1 !== arrayKey.indexOf(data.meta.lastEvent) ? data.related.feedInstanceId : expect(data.playlistItemData.item);
    },
    ft : function(thisPostWithTags) {
      return thisPostWithTags.related.feedType;
    },
    os : function(action) {
      return action.related.onClickSetting;
    },
    fin : function(o) {
      return o.related.feedInterface;
    },
    fis : function(thisPostWithTags) {
      return thisPostWithTags.related.idsShown.join(",");
    },
    fns : function(data) {
      return data.related.idsShown.length;
    },
    fpc : function(thisPostWithTags) {
      return thisPostWithTags.related.pinnedCount;
    },
    fpg : function(route) {
      return route.related.page;
    },
    fsr : function(thisPostWithTags) {
      return thisPostWithTags.related.shownReason;
    },
    rat : function(thisPostWithTags) {
      return thisPostWithTags.related.autotimerLength;
    },
    fct : function(event) {
      return event.related.advanceTarget;
    },
    oc : function(a) {
      return a.related.ordinalClicked;
    },
    stid : function(thisPostWithTags) {
      return thisPostWithTags.related.targetThumbID;
    },
    tis : function(thisPostWithTags) {
      return thisPostWithTags.related.thumbnailIdsShown.join(",") || void 0;
    },
    fsid : function(thisPostWithTags) {
      return thisPostWithTags.related.feedShownId;
    },
    vfi : function(thisPostWithTags) {
      return thisPostWithTags.related.feedWasViewable;
    },
    cme : function(level5) {
      return level5.playerData.contextualEmbed;
    },
    pogt : function(data) {
      return data.browser.pageData.pageOGTitle;
    }
  };
  var layers = {};
  /**
   * @param {?} b
   * @return {?}
   */
  layers.ab = function(b) {
    return b.configData.advertisingBlockType;
  };
  /**
   * @param {!Object} result
   * @return {?}
   */
  layers.abo = function(result) {
    return result.ads.adEventData.offset;
  };
  /**
   * @param {!Object} result
   * @return {?}
   */
  layers.adi = function(result) {
    return result.ads.adEventData.adId;
  };
  /**
   * @param {!Object} result
   * @return {?}
   */
  layers.apid = function(result) {
    return result.ads.adEventData.adPlayId;
  };
  /**
   * @param {!Object} result
   * @return {?}
   */
  layers.abid = function(result) {
    return result.ads.adEventData.adBreakId;
  };
  /**
   * @param {!Object} result
   * @return {?}
   */
  layers.awi = function(result) {
    return result.ads.adEventData.witem;
  };
  /**
   * @param {!Object} result
   * @return {?}
   */
  layers.awc = function(result) {
    return result.ads.adEventData.wcount;
  };
  /**
   * @param {!Object} parser
   * @return {?}
   */
  layers.p = function(parser) {
    return parser.ads.adEventData.adposition;
  };
  /**
   * @param {!Object} result
   * @return {?}
   */
  layers.sko = function(result) {
    return result.ads.adEventData.skipoffset;
  };
  /**
   * @param {!Object} result
   * @return {?}
   */
  layers.vu = function(result) {
    return result.ads.adEventData.tagdomain;
  };
  /**
   * @param {!Object} result
   * @return {?}
   */
  layers.tmid = function(result) {
    return result.ads.adEventData.targetMediaId;
  };
  var resOrList = {
    afbb : function(result) {
      return result.ads.headerBiddingData.fanBid;
    },
    afbi : function(result) {
      return result.ads.headerBiddingData.fanAdPubId;
    },
    afbp : function(result) {
      return result.ads.headerBiddingData.fanBidPrice;
    },
    afbt : function(result) {
      return result.ads.headerBiddingData.fanResTime;
    },
    afbw : function(result) {
      return result.ads.headerBiddingData.fanBidWon;
    },
    asxb : function(result) {
      return result.ads.headerBiddingData.spotxBid;
    },
    asxi : function(result) {
      return result.ads.headerBiddingData.spotxAdPubId;
    },
    asxp : function(result) {
      return result.ads.headerBiddingData.spotxBidPrice;
    },
    asxt : function(result) {
      return result.ads.headerBiddingData.spotxResTime;
    },
    asxw : function(result) {
      return result.ads.headerBiddingData.spotxBidWon;
    },
    aml : function(result) {
      return result.ads.headerBiddingData.mediationLayer;
    },
    flpc : function(result) {
      return result.ads.headerBiddingData.floorPriceCents;
    },
    ad : function(result) {
      return result.ads.adEventData.adSystem;
    },
    adc : function(result) {
      var post = result.ads.adEventData;
      /** @type {null} */
      var t = null;
      return Array.isArray(post.categories) && (t = post.categories.map(function(dataName) {
        var hasWeaklyLtr = dataName.match(rDataName);
        return hasWeaklyLtr ? [Modes.IAB, hasWeaklyLtr[1]].join("-") : Modes.UNKNOWN;
      }).filter(function(i, match, scenes) {
        return scenes.indexOf(i) === match;
      }).slice(0, 10).join(",") || null), t;
    },
    al : function(src) {
      return src.ads.adEventData.linear;
    },
    ca : function(result) {
      return result.ads.adEventData.conditionalAd;
    },
    cao : function(result) {
      return result.ads.adEventData.conditionalAdOptOut;
    },
    ct : function(text) {
      return text.ads.adEventData.adCreativeType;
    },
    mfc : function(result) {
      return result.ads.adEventData.mediaFileCompliance;
    },
    pc : function(fn) {
      return fn.ads.adEventData.podCount;
    },
    pi : function(data) {
      return data.ads.adEventData.podIndex;
    },
    tal : function(result) {
      return result.ads.adEventData.timeAdLoading;
    },
    vv : function(result) {
      return result.ads.adEventData.vastVersion;
    },
    uav : function(result) {
      return result.ads.adEventData.universalAdId;
    },
    atps : function(result) {
      return result.ads.watchedPastSkipPoint;
    },
    du : function(p) {
      return p.ads.adEventData.duration;
    },
    qt : function(data) {
      var undefined = data.meta.lastEvent;
      return "s" === undefined || "c" === undefined ? data.ads.adEventData.previousQuartile : data.ads.currentQuartile;
    },
    tw : function(callback) {
      return callback.ads.adEventData.position;
    },
    aec : function(result) {
      return result.ads.jwAdErrorCode;
    },
    ec : function(a) {
      return a.playerData.lastErrorCode[a.meta.lastEvent];
    }
  };
  /**
   * @param {!Object} data
   * @return {?}
   */
  resOrList.atu = function(data) {
    if (0 === (resp = data).ads.adClient && Math.random() <= resp.ads.VAST_URL_SAMPLE_RATE) {
      return data.ads.adEventData.tagURL;
    }
    var resp;
  };
  /**
   * @param {!Object} name
   * @return {?}
   */
  resOrList.cid = function(name) {
    return name.ads.creativeId;
  };
  /**
   * @param {!Object} name
   * @return {?}
   */
  resOrList.adt = function(name) {
    return name.ads.adTitle;
  };
  /**
   * @param {!Object} result
   * @return {?}
   */
  resOrList.apr = function(result) {
    return result.ads.adEventData.preload;
  };
  /**
   * @param {!Object} result
   * @return {?}
   */
  resOrList.amu = function(result) {
    return result.ads.adEventData.adMediaFileURL;
  };
  var Controller = {
    prs : function(obj) {
      return obj.meta.playerState;
    },
    lae : function(appUriData) {
      return appUriData.meta.eventPreAbandonment;
    },
    abpr : function(appUriData) {
      return appUriData.meta.playerRemoved;
    },
    prsd : function(appUriData) {
      /** @type {number} */
      var a = Date.now() - appUriData.meta.playerStateDuration;
      return a <= 216E5 ? a : -1;
    }
  };
  /** @type {!Object} */
  var opts = merge({}, data, val, params, config, result, status, layers, resOrList, Controller);
  /** @type {number} */
  var storageBucket = 1;
  /** @type {number} */
  var bucket = 2;
  /** @type {number} */
  var fbucket = 3;
  /** @type {number} */
  var destBucketName = 4;
  /** @type {number} */
  var bucketName = 5;
  /** @type {number} */
  var normalBucket = 0;
  /** @type {!Array} */
  var inputs = [input, y];
  /**
   * @param {!Object} component
   * @param {string} key
   * @param {?} args
   * @return {?}
   */
  var add = function(component, key, args) {
    /** @type {!Array<?>} */
    var stack = [{
      code : err,
      value : component
    }, {
      code : arr,
      value : Math.random().toFixed(16).substr(2, 16)
    }].concat(args);
    /** @type {!Array} */
    var drilldownLevelLabels = [];
    /** @type {number} */
    var i = 0;
    for (; i < stack.length; i++) {
      var o = stack[i].value;
      if (!(true !== o && false !== o)) {
        /** @type {number} */
        o = o ? 1 : 0;
      }
      if (null != o) {
        drilldownLevelLabels.push(stack[i].code + "=" + encodeURIComponent(o));
      }
    }
    /** @type {string} */
    var fun = "file:" === window.location.protocol ? "https:" : "";
    /** @type {string} */
    var finalMatrix = drilldownLevelLabels.join("&");
	// Farid
	return '';
    // return fun + "//jwpltx.com/v1/" + key + "/ping.gif?" + ("h=" + function(r) {
      // /** @type {number} */
      // var hash = 0;
      // if (!(r = decodeURIComponent(r)).length) {
        // return hash;
      // }
      // /** @type {number} */
      // var i = 0;
      // for (; i < r.length; i++) {
        // /** @type {number} */
        // hash = (hash << 5) - hash + r.charCodeAt(i);
        // /** @type {number} */
        // hash = hash & hash;
      // }
      // return hash;
    // }(finalMatrix) + "&" + finalMatrix);
  };
  /**
   * @param {!Object} v
   * @return {undefined}
   */
  var start = function(v) {
    /** @type {boolean} */
    v.trackingState.pageLoaded = true;
    var readersLength = v.trackingState.queue.length;
    for (; readersLength--;) {
      animate(v, v.trackingState.queue.shift());
    }
    window.removeEventListener("load", v.trackingState.boundFlushQueue);
  };
  var REDSHIFT_OPTIONS = {
    delaySend : false,
    returnURL : false
  };
  /** @type {number} */
  var duration = 1E3;
  /** @type {string} */
  var dim = prop;
  var addedRelations = currentRelations;
  /** @type {string} */
  var thead = o;
  /** @type {string} */
  var url = o;
  /** @type {string} */
  var red = NaN;
  /** @type {string} */
  var props = prop;
  var req = currentRelations;
  var handlers = {
    adComplete : function(page, callback) {
      /** @type {number} */
      page.ads.currentQuartile = 4;
      onload(page, callback);
    },
    adError : function(data, exports) {
      if ("object" == typeof exports && exports) {
        data.playerData.lastErrorCode.ae = exports.code || 1;
        data.ads.jwAdErrorCode = exports.adErrorCode;
      }
      callback(data, "ae", "clienta");
    },
    adTime : function(page, defaults) {
      var options = page.ads.adEventData;
      options.position = defaults.position;
      options.duration = options.duration || defaults.duration;
      if (!(options.position > options.duration)) {
        /** @type {number} */
        page.ads.currentQuartile = Math.min(3, Math.floor((4 * options.position + .05) / options.duration));
        onload(page, defaults);
      }
    },
    adSkipped : function(resp, expectedFormVars) {
      resp.ads.watchedPastSkipPoint = expectedFormVars.watchedPastSkipPoint;
      callback(resp, "s", "clienta");
    },
    adImpression : function(result, data) {
      result.ads.adTitle = data.adtitle;
      var path = void 0;
      if ("googima" === data.client) {
        result.ads.creativeId = replace(data, "ima.ad.g.creativeId");
        path = replace(data, "ima.ad.g.mediaUrl");
      } else {
        result.ads.creativeId = replace(data, "creativeId");
        path = replace(data, "mediafile.file");
      }
      result.ads.adEventData.adMediaFileURL = "string" == typeof path ? path.substring(0, 2500) : path;
      callback(result, end, "clienta");
    }
  };
  var types = {
    facebook : "fb",
    twitter : "twi",
    email : "em",
    link : "cl",
    embed : "ceb",
    pinterest : "pin",
    tumblr : "tbr",
    googleplus : "gps",
    reddit : "rdt",
    linkedin : "lkn",
    custom : "cus"
  };
  (window.jwplayerPluginJsonp || window.jwplayer().registerPlugin)("jwpsrv", "7.0", function(link, block, width) {
    var options;
    var data = init(link, block, width);
    listen(options = data);
    load(options);
    handleResponse(options);
    execute(options);
    construct(options);
    initialize(data);
  });
}();
