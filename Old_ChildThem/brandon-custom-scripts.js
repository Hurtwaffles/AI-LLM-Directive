// ==== BRANDON: GLOBAL SPA JS (Fully Optimized & Documented) ====
// Version: 2.6.7.8 (Syntax Fix in P5 Init, Isolate P5, Enhanced P5 Dim Logging)
// Date: 2025-06-15
// Author: Brandon Leach
// Description: Optimized custom animations and interactions for Semplice WordPress theme

(function() {
  'use strict';

  // ========== CONFIGURATION OBJECTS ==========
  const BRANDON_CONFIG = {
    debug: true, 
    grid: { subdivisions: 12, gapFactor: 8, baseDotSize: 1.5 },
    wave: { dotColor: [42, 42, 46], alphaReveal: 77, thickness: 145, speed: 247, frontRatio: 0.44, backRatio: 2.6 },
    timing: { buttonPress: 180, dotAnimation: 0.5, waveExpansion: 247 }
  };
  
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function brandonLog(...args) {
    if (BRANDON_CONFIG.debug && window && window.console) {
      console.log('[BRANDON CUSTOM]', ...args);
    }
  }

  function initializeGSAP() {
    if (window.gsap && window.CustomEase) {
      if (!CustomEase.get("circleEase")) { 
        CustomEase.create("circleEase", "0.68, -0.55, 0.265, 1.55"); 
      }
      if (!CustomEase.get("rebrandEase")) { 
        CustomEase.create("rebrandEase", "M0,0 C0.266,0.112 0.24,1.422 0.496,1.52 0.752,1.618 0.734,0.002 1,0"); 
      }
      brandonLog("GSAP and CustomEases ('circleEase', 'rebrandEase') loaded.");
      return true;
    }
    brandonLog("GSAP or CustomEase missing!");
    return false;
  }

  function isElement(el) { return el && el.closest && typeof el.closest === 'function'; }

  function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
      const later = () => { clearTimeout(timeout); func(...args); };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  }

  function initializeButtonHandlers() {
    if (window._brandonNavBtnHandlersInitialized) {
        brandonLog("Button Handlers: Already initialized, skipping.");
        return;
    }
    window._brandonNavBtnHandlersInitialized = true;
    brandonLog("Initializing Button Handlers (v2.6.7.3 logic - stable)."); 
    const buttonSelector = '.brandon-animated-button-reveal, .brandon-logo-reveal-link';
    const workMenuSelector = '.brandon-work-menu-trigger'; 
    const pressEvents = ['mousedown', 'touchstart', 'keydown'];
    const releaseEvents = ['mouseup', 'mouseleave', 'touchend', 'touchcancel', 'keyup', 'blur'];

    pressEvents.forEach(evt => {
      document.addEventListener(evt, e => {
        const btn = isElement(e.target) ? e.target.closest(buttonSelector) : null;
        if (btn) {
          if (evt === 'keydown' && !['Enter', ' '].includes(e.key)) return;
          btn.classList.add('pressed');
          setTimeout(() => btn.classList.remove('pressed'), BRANDON_CONFIG.timing.buttonPress);
        }
      }, { passive: true, capture: true });
    });

    releaseEvents.forEach(evt => {
      document.addEventListener(evt, e => {
        const btn = isElement(e.target) ? e.target.closest(buttonSelector) : null;
        if (btn) btn.classList.remove('pressed');
      }, { passive: true, capture: true });
    });

    document.addEventListener('click', e => {
      const clickedElement = isElement(e.target) ? e.target : null;
      if (!clickedElement) return;

      const workMenuTriggerElement = clickedElement.closest(workMenuSelector); 
      
      if (workMenuTriggerElement) {
        e.preventDefault(); 
        brandonLog('Work menu trigger element clicked:', workMenuTriggerElement);

        const sempliceHamburger = document.querySelector('.open-menu.menu-icon') || 
                                  document.querySelector('.hamburger') || 
                                  document.querySelector('[data-module="menu"] .hamburger, [data-menu-type="hamburger"] .hamburger');

        if (sempliceHamburger) {
          brandonLog('A .brandon-work-menu-trigger was clicked. Attempting to click Semplice hamburger.');
          sempliceHamburger.click();
        } else {
          brandonLog('Semplice native menu trigger (hamburger) not found on page.');
        }
      }
    }, { capture: true });
  }

  // ========== DOTS GRID MENU ANIMATION (SELF-CONTAINED) ==========
  function initializeDotsGridMenu() {
    if (prefersReducedMotion) {
      brandonLog('DOT GRID: Reduced motion, animation disabled.');
      return;
    }
    if (!initializeGSAP()) { 
      brandonLog("DOT GRID: GSAP not ready, skipping initialization.");
      return;
    }
    const menuBtn = document.getElementById('brandonDotsGridMenu');
    if (!menuBtn) {
      brandonLog('DOT GRID: Menu button (#brandonDotsGridMenu) not found.');
      return;
    }
    if (menuBtn.dataset.brandonDotsInitialized === 'true') {
      brandonLog('DOT GRID: Already initialized for this instance.');
      return;
    }
    menuBtn.dataset.brandonDotsInitialized = 'true';
    brandonLog('DOT GRID: Initializing animation (v2.6.7.5 - Corrected Corner Outward Movement).');
    const dots = Array.from(menuBtn.querySelectorAll('.brandon-dot'));
    if (dots.length !== 9) {
      brandonLog('DOT GRID: Incorrect dot count. Expected 9, found', dots.length);
      return;
    }

    const SPACING = 8; 
    const CORNER_OUTWARD_MULTIPLIER = 1.25; 
    const CORNER_TARGET_ABS_POS = SPACING * CORNER_OUTWARD_MULTIPLIER;

    const CENTER_DOT_SCALE = 1; 
    const VISIBLE_DOT_OPACITY = 1;
    const DURATION = BRANDON_CONFIG.timing.dotAnimation;
    let isOpen = false;

    dots.forEach((dot, i) => {
      gsap.set(dot, {
        x: (i % 3) * SPACING - SPACING,
        y: Math.floor(i / 3) * SPACING - SPACING,
        scale: 1,
        opacity: 1,
        transformOrigin: 'center center'
      });
    });
    brandonLog('DOT GRID: Initial 3x3 grid state set using individual GSAP.set().');

    const xStateProperties = dots.map((dot, i) => {
      switch (i) {
        case 0: return { x: -CORNER_TARGET_ABS_POS, y: -CORNER_TARGET_ABS_POS, opacity: VISIBLE_DOT_OPACITY, scale: 1 }; 
        case 2: return { x: CORNER_TARGET_ABS_POS,  y: -CORNER_TARGET_ABS_POS, opacity: VISIBLE_DOT_OPACITY, scale: 1 }; 
        case 6: return { x: -CORNER_TARGET_ABS_POS, y: CORNER_TARGET_ABS_POS,  opacity: VISIBLE_DOT_OPACITY, scale: 1 }; 
        case 8: return { x: CORNER_TARGET_ABS_POS,  y: CORNER_TARGET_ABS_POS,  opacity: VISIBLE_DOT_OPACITY, scale: 1 }; 
        case 4: return { x: 0,                      y: 0,                      opacity: VISIBLE_DOT_OPACITY, scale: CENTER_DOT_SCALE }; 
        case 1: return { x: 0, y: 0, opacity: VISIBLE_DOT_OPACITY, scale: 1 };        
        case 3: return { x: 0, y: 0, opacity: VISIBLE_DOT_OPACITY, scale: 1 };        
        case 5: return { x: 0, y: 0, opacity: VISIBLE_DOT_OPACITY, scale: 1 };       
        case 7: return { x: 0, y: 0, opacity: VISIBLE_DOT_OPACITY, scale: 1 };  
        default: return {};
      }
    });

    const masterTimeline = gsap.timeline({ 
        paused: true,
        onStart: () => brandonLog(`DOT GRID Timeline: Animation ${isOpen ? 'to X/Center Stack' : 'to Grid'} started.`),
        onComplete: () => brandonLog(`DOT GRID Timeline: Animation ${isOpen ? 'to X/Center Stack' : 'to Grid'} completed. isOpen: ${isOpen}`),
    });

    dots.forEach((dot, i) => {
        masterTimeline.to(dot, { ...xStateProperties[i], duration: DURATION, ease: "circleEase" }, 0);
    });

    menuBtn.addEventListener('click', () => {
      isOpen = !isOpen;
      brandonLog(`DOT GRID: Clicked. isOpen is now ${isOpen}`);
      if (isOpen) {
        brandonLog("DOT GRID: Playing to X/Center Stack form.");
        masterTimeline.play();
      } else {
        brandonLog("DOT GRID: Reversing to Grid form.");
        masterTimeline.reverse();
      }
    });
    brandonLog('DOT GRID: Click listener added.');
  }

  function initializeSmoothScrollHandlers() {
    if (window._brandonSmoothScrollInitialized) {
        brandonLog("Smooth Scroll Handlers: Already initialized, skipping.");
        return;
    }
    window._brandonSmoothScrollInitialized = true;
    brandonLog("Initializing Smooth Scroll Handlers");
    const scrollLinks = document.querySelectorAll('.brandon-logo-reveal-link[href^="#"], .brandon-animated-button-reveal[href^="#"]');
    scrollLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        const linkUrl = new URL(this.href);
        const currentUrl = new URL(window.location.href);
        if (linkUrl.pathname === currentUrl.pathname && linkUrl.search === currentUrl.search) {
          e.preventDefault();
          e.stopPropagation();
          const targetId = linkUrl.hash;
          try {
            if (targetId && targetId !== '#') {
              const targetElement = document.querySelector(targetId);
              if (targetElement) {
                brandonLog(`Smooth scrolling to: ${targetId}`);
                targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
              } else {
                brandonLog(`Smooth scroll target ${targetId} not found.`);
              }
            } else {
              brandonLog('Smooth scrolling to top of page.');
              window.scrollTo({ top: 0, behavior: 'smooth' });
            }
          } catch (error) {
            console.error('Smooth scroll error:', targetId, error);
          }
        }
      });
    });
  }

  function createSafeP5Instance(factory, element, label) {
    if (prefersReducedMotion) {
      brandonLog(`P5: Reduced motion, sketch "${label}" disabled.`);
      return;
    }
    if (typeof p5 === 'undefined') {
      brandonLog(`P5: Library not loaded. Cannot create sketch "${label}".`);
      return null; 
    }
    const existingCanvas = element.querySelector('canvas');
    if (existingCanvas) {
      brandonLog(`P5: Removing existing canvas for sketch "${label}" before creating new one.`);
      existingCanvas.remove();
    }
    brandonLog(`P5: Attempting to create sketch "${label}" in element:`, element);
    try {
      const sketch = new p5(factory(element), element); 
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            if (sketch && typeof sketch.loop === 'function' && typeof sketch.isLooping === 'function' && !sketch.isLooping()) {
              brandonLog(`P5: Sketch "${label}" entered viewport, calling loop().`);
              sketch.loop();
            }
          } else {
            if (sketch && typeof sketch.noLoop === 'function' && typeof sketch.isLooping === 'function' && sketch.isLooping()) {
              brandonLog(`P5: Sketch "${label}" exited viewport, calling noLoop().`);
              sketch.noLoop();
            }
          }
        });
      }, { threshold: 0.01 }); 
      observer.observe(element);
      brandonLog(`P5: Sketch "${label}" initialized and observer attached.`);
      return sketch; 
    } catch (error) { // Corrected: Added opening brace for catch
      console.error(`P5 error in ${label}:`, error);
      return null; 
    }
  }

  function waitForElementSizeAndInit(element, p5Factory, label, maxWaitTime = 3000) {
    const startTime = Date.now();
    function attemptInit() {
      if (!element.isConnected) { 
        brandonLog(`P5 Init: Element for "${label}" no longer connected to DOM. Aborting.`);
        return;
      }
      
      const parentEl = element.parentElement;
      let parentRect = null;
      if (parentEl) {
          parentRect = parentEl.getBoundingClientRect();
          brandonLog(`P5 Init: Parent for "${label}" (${parentEl.tagName}.${parentEl.className}) size: ${parentRect.width.toFixed(1)}x${parentRect.height.toFixed(1)}.`);
      } else {
          brandonLog(`P5 Init: Parent for "${label}" not found.`);
      }

      const rect = element.getBoundingClientRect();
      const hasSize = rect.width > 10 && rect.height > 10;
      const hasCanvas = element.querySelector('canvas');
      const timeElapsed = Date.now() - startTime;

      if (hasSize && !hasCanvas) {
        brandonLog(`P5 Init: Element for "${label}" has size (${rect.width.toFixed(1)}x${rect.height.toFixed(1)}). Creating instance.`);
        createSafeP5Instance(p5Factory, element, label);
      } else if (hasCanvas) {
         brandonLog(`P5 Init: Element for "${label}" already has a canvas. Size: ${rect.width.toFixed(1)}x${rect.height.toFixed(1)}`);
      } else if (timeElapsed < maxWaitTime) {
        brandonLog(`P5 Init: Waiting for size for "${label}". Current: ${rect.width.toFixed(1)}x${rect.height.toFixed(1)}. Time elapsed: ${timeElapsed}ms`);
        setTimeout(attemptInit, 250);
      } else {
        brandonLog(`P5 Init: Max wait time reached for "${label}". Could not initialize. Final size: ${rect.width.toFixed(1)}x${rect.height.toFixed(1)}`);
      }
    }
    attemptInit();
  }
  
  function injectBackgroundContainers() {
    brandonLog("P5: Injecting background containers and initializing sketches (v2.6.7.7 logic).");
    const sectionConfigs = [
      { sectionClass: 'brandon-bg-load-wave', bgClass: 'brandon-load-wave', factory: createLoadWaveSketch, label: 'load-wave' },
      { sectionClass: 'brandon-bg-main-bg', bgClass: 'brandon-main-background', factory: createHazeBackgroundSketch, label: 'main-background' },
      { sectionClass: 'brandon-bg-main-bg2', bgClass: 'brandon-main-background2', factory: createWhiteHazeBackgroundSketch, label: 'main-background2' }
    ];
    sectionConfigs.forEach(config => {
      document.querySelectorAll(`smp-section.${config.sectionClass}`).forEach(section => {
        let backgroundDiv = section.querySelector(`div.${config.bgClass}`);
        
        const sectionRect = section.getBoundingClientRect();
        if (sectionRect.height < 50 && section.classList.contains('brandon-bg-main-bg')) { 
            brandonLog(`P5 WARNING: Section for "${config.label}" has small height: ${sectionRect.height.toFixed(1)}px. Ensure it has CSS height (e.g., min-height: 100vh).`);
        }

        if (!backgroundDiv) {
          backgroundDiv = document.createElement('div');
          backgroundDiv.className = config.bgClass;

          backgroundDiv.style.position = 'absolute';
          backgroundDiv.style.top = '0';
          backgroundDiv.style.left = '0';
          backgroundDiv.style.width = '100%';
          backgroundDiv.style.height = '100%';
          backgroundDiv.style.pointerEvents = 'none'; 
          backgroundDiv.style.zIndex = '0'; 

          if (window.getComputedStyle(section).position === 'static') {
            section.style.position = 'relative';
            brandonLog(`P5: Set position:relative on section for ${config.label}`);
          }
          
          const contentWrapper = section.querySelector('.smp-content-wrapper');
          if (contentWrapper) {
            if (window.getComputedStyle(contentWrapper).position === 'static') {
                 contentWrapper.style.position = 'relative';
            }
            contentWrapper.style.zIndex = '1'; 
            section.insertBefore(backgroundDiv, contentWrapper); 
            brandonLog(`P5: Created and styled background div for ${config.label}, inserted before content wrapper.`);
          } else {
            section.prepend(backgroundDiv); 
            brandonLog(`P5: Created and styled background div for ${config.label}, prepended to section.`);
          }
        } else { 
            backgroundDiv.style.position = 'absolute';
            backgroundDiv.style.top = '0';
            backgroundDiv.style.left = '0';
            backgroundDiv.style.width = '100%';
            backgroundDiv.style.height = '100%';
            backgroundDiv.style.pointerEvents = 'none';
            backgroundDiv.style.zIndex = '0';
             if (window.getComputedStyle(section).position === 'static') {
                section.style.position = 'relative';
            }
            const contentWrapper = section.querySelector('.smp-content-wrapper');
            if (contentWrapper && window.getComputedStyle(contentWrapper).position === 'static') {
                contentWrapper.style.position = 'relative';
                contentWrapper.style.zIndex = '1'; 
            }
            brandonLog(`P5: Found existing background div for ${config.label}, ensured styles.`);
        }
        waitForElementSizeAndInit(backgroundDiv, config.factory, config.label);
      });
    });
  }

  function getResponsiveGridSettings(canvasWidth) {
    if (canvasWidth < 600) return { DOT_GAP: 16, BASE_DOT_SIZE: 2 };
    if (canvasWidth < 1440) return { DOT_GAP: 12, BASE_DOT_SIZE: 1.5 };
    return { DOT_GAP: 16, BASE_DOT_SIZE: 2 };
  }

  function computeGrid(w, h, dotGap, baseDotSize) {
    const spacing = dotGap + baseDotSize * 2;
    const cols = Math.ceil(w / spacing);
    const rows = Math.ceil(h / spacing);
    const result = [];
    for (let r = 0; r < rows; r++) {
      for (let c = 0; c < cols; c++) {
        result.push({ x: c * spacing + spacing / 2, y: r * spacing + spacing / 2 });
      }
    }
    return result;
  }

  function createHazeBackgroundSketch(containerElement) {
    return (p) => {
      const DOT_COLOR = [42, 42, 46];      
      const BG_COLOR = [14, 14, 16];       
      const BLOB_SCALE = 0.005, THRESHOLD = 0.64, FADE_RANGE = 0.17, ANIM_SPEED = 0.0002;
      let DOT_GAP, BASE_DOT_SIZE;
      function alphaRamp(x) { let t = Math.max(0, Math.min(1, x)); return t * t * (3 - 2 * t); }
      p.setup = function() {
        p.createCanvas(containerElement.offsetWidth, containerElement.offsetHeight).style('pointer-events', 'none');
        p.noStroke();
        ({ DOT_GAP, BASE_DOT_SIZE } = getResponsiveGridSettings(p.width));
        if (!prefersReducedMotion) p.loop(); else p.noLoop();
      };
      p.draw = function() {
        p.background(...BG_COLOR);
        const t = p.millis() * ANIM_SPEED;
        for (let x = DOT_GAP / 2; x < p.width; x += DOT_GAP) {
          for (let y = DOT_GAP / 2; y < p.height; y += DOT_GAP) {
            const nx = x * BLOB_SCALE, ny = y * BLOB_SCALE;
            const field = 0.7 * p.noise(nx, ny, t) + 0.25 * p.noise(nx * 0.6, ny * 0.6, t * 1.7 + 99) + 0.13 * p.noise(nx * 2.0, ny * 2.0, t * 0.8 - 7);
            const rawAlpha = (field - (THRESHOLD - FADE_RANGE)) / (2 * FADE_RANGE);
            const alpha = alphaRamp(rawAlpha);
            if (alpha > 0.02) {
              p.fill(...DOT_COLOR, alpha * 255);
              p.ellipse(x, y, BASE_DOT_SIZE * 2, BASE_DOT_SIZE * 2);
            }
          }
        }
      };
      p.windowResized = debounce(function() {
        if (!containerElement.isConnected || !containerElement.offsetWidth || !containerElement.offsetHeight) return;
        p.resizeCanvas(containerElement.offsetWidth, containerElement.offsetHeight);
        ({ DOT_GAP, BASE_DOT_SIZE } = getResponsiveGridSettings(p.width));
        if (p.isLooping()) p.redraw(); 
      }, 150);
    };
  }

  function createWhiteHazeBackgroundSketch(containerElement) {
    return (p) => {
      const DOT_COLOR = [158, 158, 167];   
      const BG_COLOR = [242, 242, 243];    
      const BLOB_SCALE = 0.005, THRESHOLD = 0.64, FADE_RANGE = 0.17, ANIM_SPEED = 0.0002;
      let DOT_GAP, BASE_DOT_SIZE;
      function alphaRamp(x) { let t = Math.max(0, Math.min(1, x)); return t * t * (3 - 2 * t); }
      p.setup = function() {
        p.createCanvas(containerElement.offsetWidth, containerElement.offsetHeight).style('pointer-events', 'none');
        p.noStroke();
        ({ DOT_GAP, BASE_DOT_SIZE } = getResponsiveGridSettings(p.width));
        if (!prefersReducedMotion) p.loop(); else p.noLoop();
      };
      p.draw = function() {
        p.background(...BG_COLOR);
        const t = p.millis() * ANIM_SPEED;
        for (let x = DOT_GAP / 2; x < p.width; x += DOT_GAP) {
          for (let y = DOT_GAP / 2; y < p.height; y += DOT_GAP) {
            const nx = x * BLOB_SCALE, ny = y * BLOB_SCALE;
            const field = 0.7 * p.noise(nx, ny, t) + 0.25 * p.noise(nx * 0.6, ny * 0.6, t * 1.7 + 99) + 0.13 * p.noise(nx * 2.0, ny * 2.0, t * 0.8 - 7);
            const rawAlpha = (field - (THRESHOLD - FADE_RANGE)) / (2 * FADE_RANGE);
            const alpha = alphaRamp(rawAlpha);
            if (alpha > 0.02) {
              p.fill(...DOT_COLOR, alpha * 255);
              p.ellipse(x, y, BASE_DOT_SIZE * 2, BASE_DOT_SIZE * 2);
            }
          }
        }
      };
      p.windowResized = debounce(function() {
        if (!containerElement.isConnected || !containerElement.offsetWidth || !containerElement.offsetHeight) return;
        p.resizeCanvas(containerElement.offsetWidth, containerElement.offsetHeight);
        ({ DOT_GAP, BASE_DOT_SIZE } = getResponsiveGridSettings(p.width));
         if (p.isLooping()) p.redraw();
      }, 150);
    };
  }

  function createLoadWaveSketch(containerElement) {
    return (p) => {
      const { dotColor, alphaReveal, thickness, speed, frontRatio, backRatio } = BRANDON_CONFIG.wave;
      const BG_COLOR = [14, 14, 16];
      let dotsArr = [], centerX, centerY, maxDist, startTime;
      let DOT_GAP, BASE_DOT_SIZE;
      p.setup = function() {
        p.createCanvas(containerElement.offsetWidth, containerElement.offsetHeight).style('pointer-events', 'none');
        p.noStroke();
        ({ DOT_GAP, BASE_DOT_SIZE } = getResponsiveGridSettings(p.width));
        dotsArr = computeGrid(p.width, p.height, DOT_GAP, BASE_DOT_SIZE);
        centerX = p.width / 2;
        centerY = p.height / 2;
        maxDist = Math.sqrt(centerX * centerX + centerY * centerY) + thickness;
        startTime = p.millis();
        if (!prefersReducedMotion) p.loop(); else p.noLoop();
      };
      p.draw = function() {
        p.background(...BG_COLOR);
        const elapsedSec = (p.millis() - startTime) * 0.001;
        const fullDist = elapsedSec * speed;
        const revealDist = Math.min(fullDist, maxDist);
        const cycleLen = maxDist + thickness;
        const pulseDist = (fullDist % cycleLen);
        dotsArr.forEach(dot => {
          const d = p.dist(dot.x, dot.y, centerX, centerY);
          if (d <= revealDist) {
            p.fill(...dotColor, alphaReveal);
            p.ellipse(dot.x, dot.y, BASE_DOT_SIZE * 2, BASE_DOT_SIZE * 2);
          }
        });
        const frontRange = thickness * frontRatio;
        const backRange = thickness * backRatio;
        dotsArr.forEach(dot => {
          const dx = dot.x - centerX, dy = dot.y - centerY;
          const d = Math.sqrt(dx * dx + dy * dy);
          if (d <= revealDist) {
            const delta = d - pulseDist;
            let pulse = 0;
            if (delta >= -backRange && delta <= frontRange) {
              pulse = delta > 0 ? 1 - delta / frontRange : 1 - Math.abs(delta) / backRange;
              pulse = Math.pow(pulse, 0.6);
              pulse = Math.sin(pulse * Math.PI / 2);
            }
            if (pulse > 0.01) {
              let mag = delta >= 0 ? 1 - (delta / frontRange) : 1 - (Math.abs(delta) / backRange) * 0.5;
              mag = Math.max(0, Math.min(1, mag)) * pulse;
              let warp = delta >= 0 ? mag * BASE_DOT_SIZE : 0;
              const ux = dx / (d || 1), uy = dy / (d || 1);
              const wx = ux * warp, wy = uy * warp;
              const size = BASE_DOT_SIZE + BASE_DOT_SIZE * mag;
              const alpha = 0.3 + 0.7 * pulse;
              p.fill(...dotColor, alpha * 255);
              p.ellipse(dot.x + wx, dot.y + wy, size * 2, size * 2);
            }
          }
        });
      };
      p.windowResized = debounce(function() {
        if (!containerElement.isConnected || !containerElement.offsetWidth || !containerElement.offsetHeight) return;
        p.resizeCanvas(containerElement.offsetWidth, containerElement.offsetHeight);
        ({ DOT_GAP, BASE_DOT_SIZE } = getResponsiveGridSettings(p.width));
        dotsArr = computeGrid(p.width, p.height, DOT_GAP, BASE_DOT_SIZE);
        centerX = p.width / 2;
        centerY = p.height / 2;
        maxDist = Math.sqrt(centerX * centerX + centerY * centerY) + thickness;
        if (p.isLooping()) p.redraw();
      }, 150);
    };
  }
  
  function initializeBrandonComponents() {
    brandonLog("Initializing Brandon Components (Full Run v2.6.7.8)");
    initializeGSAP(); 
    initializeButtonHandlers(); 
    initializeDotsGridMenu(); 
    initializeSmoothScrollHandlers();
    try {
        injectBackgroundContainers(); 
    } catch (e) {
        console.error("P5: Error during injectBackgroundContainers call:", e);
        brandonLog("P5: Error during injectBackgroundContainers call. Other components should still be initialized.");
    }
  }

  function cleanupBeforeInit() {
    brandonLog("Cleaning up before re-initialization (SPA transition).");
    document.querySelectorAll('.brandon-load-wave, .brandon-main-background, .brandon-main-background2').forEach(el => {
        const p5canvas = el.querySelector('canvas');
        if (p5canvas) {
            brandonLog("P5: Removing canvas from", el.className);
            p5canvas.remove();
        }
    });

    const menuBtn = document.getElementById('brandonDotsGridMenu');
    if (menuBtn) {
      menuBtn.removeAttribute('data-brandon-dots-initialized');
    }
    window._brandonNavBtnHandlersInitialized = false;
    window._brandonSmoothScrollInitialized = false;
    brandonLog("Cleanup: Flags reset.");
  }

  function safeInitialize() {
    brandonLog("SPA Event (sempliceAppendContent or popstate) triggered: Re-initializing components.");
    cleanupBeforeInit();
    setTimeout(initializeBrandonComponents, 250); 
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeBrandonComponents);
  } else {
    initializeBrandonComponents(); 
  }

  window.addEventListener('sempliceAppendContent', safeInitialize);
  window.addEventListener('popstate', debounce(safeInitialize, 250)); 

  window.BRANDON_DEBUG = {
    config: BRANDON_CONFIG,
    reinitialize: initializeBrandonComponents,
    cleanup: cleanupBeforeInit
  };

})();