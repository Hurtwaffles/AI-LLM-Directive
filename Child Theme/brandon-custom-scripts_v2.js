
// ==== BRANDON: GLOBAL SPA JS (Merged & Optimized) ====
// Includes: Unified dot grid, haze+wave animations, debug overlay
// Author: Brandon Leach

(function() {
  'use strict';

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const BRANDON_CONFIG = {
    debug: true,
    dot: { gap: 15, size: 1.5 },
    wave: { dotColor: [42, 42, 46], alphaReveal: 77, thickness: 145, speed: 247 },
    haze: {
      light: { bg: [242, 242, 243], dot: [158, 158, 167] },
      dark: { bg: [14, 14, 16], dot: [42, 42, 46] }
    }
  };

  function buildDotGrid(p, { dotGap = 15, dotSize = 1.5 } = {}) {
    const width = p.width, height = p.height;
    const cols = Math.floor(width / dotGap);
    const rows = Math.floor(height / dotGap);
    const offsetX = (width - cols * dotGap) / 2;
    const offsetY = (height - rows * dotGap) / 2;
    const dots = [];
    for (let i = 0; i < cols; i++) {
      for (let j = 0; j < rows; j++) {
        dots.push({ x: offsetX + i * dotGap, y: offsetY + j * dotGap, size: dotSize });
      }
    }
    return dots;
  }

  function drawGridOverlay(p, dotGap = 15, color = [255, 0, 0, 100]) {
    const cols = Math.floor(p.width / dotGap);
    const rows = Math.floor(p.height / dotGap);
    p.push();
    p.stroke(color);
    p.strokeWeight(1);
    for (let x = 0; x <= cols; x++) {
      const xPos = (p.width - cols * dotGap) / 2 + x * dotGap;
      p.line(xPos, 0, xPos, p.height);
    }
    for (let y = 0; y <= rows; y++) {
      const yPos = (p.height - rows * dotGap) / 2 + y * dotGap;
      p.line(0, yPos, p.width, yPos);
    }
    p.pop();
  }

  function createHazeSketch(container, theme = 'dark') {
    return (p) => {
      const { bg: BG_COLOR, dot: DOT_COLOR } = BRANDON_CONFIG.haze[theme] || BRANDON_CONFIG.haze.dark;
      const BLOB_SCALE = 0.005, THRESHOLD = 0.64, FADE_RANGE = 0.17, ANIM_SPEED = 0.0002;
      let dots = [];
      p.setup = function() {
        p.createCanvas(container.offsetWidth, container.offsetHeight).style('pointer-events', 'none');
        p.noStroke();
        dots = buildDotGrid(p, BRANDON_CONFIG.dot);
        if (!prefersReducedMotion) p.loop(); else p.noLoop();
      };
      p.draw = function() {
        p.background(BG_COLOR);
        const t = p.millis() * ANIM_SPEED;
        dots.forEach(({ x, y, size }) => {
          const nx = x * BLOB_SCALE, ny = y * BLOB_SCALE;
          const field = 0.7 * p.noise(nx, ny, t)
                      + 0.25 * p.noise(nx * 0.6, ny * 0.6, t * 1.7 + 99)
                      + 0.13 * p.noise(nx * 2.0, ny * 2.0, t * 0.8 - 7);
          const rawAlpha = (field - (THRESHOLD - FADE_RANGE)) / (2 * FADE_RANGE);
          const alpha = Math.max(0, Math.min(1, rawAlpha)) ** 2 * (3 - 2 * rawAlpha);
          if (alpha > 0.02) {
            p.fill(...DOT_COLOR, alpha * 255);
            p.ellipse(x, y, size * 2, size * 2);
          }
        });
        if (window.DEBUG_GRID_OVERLAY) drawGridOverlay(p);
      };
      p.windowResized = () => {
        p.resizeCanvas(container.offsetWidth, container.offsetHeight);
        dots = buildDotGrid(p, BRANDON_CONFIG.dot);
        if (p.isLooping()) p.redraw();
      };
    };
  }

  function createLoadWaveSketch(container) {
    return (p) => {
      const { dotColor, thickness, speed } = BRANDON_CONFIG.wave;
      let dots = [];
      p.setup = function() {
        p.createCanvas(container.offsetWidth, container.offsetHeight).style('pointer-events', 'none');
        p.noStroke();
        dots = buildDotGrid(p, BRANDON_CONFIG.dot);
        if (!prefersReducedMotion) p.loop(); else p.noLoop();
      };
      p.draw = function() {
        p.background(0);
        const t = p.millis() * 0.001;
        const cx = p.width / 2, cy = p.height / 2;
        dots.forEach(({ x, y, size }) => {
          const d = p.dist(x, y, cx, cy);
          const phase = (d / thickness) - (t * speed * 0.001);
          const alpha = 0.5 * (1 + Math.sin(phase));
          if (alpha > 0.01) {
            p.fill(...dotColor, alpha * 255);
            p.ellipse(x, y, size * 2, size * 2);
          }
        });
        if (window.DEBUG_GRID_OVERLAY) drawGridOverlay(p);
      };
      p.windowResized = () => {
        p.resizeCanvas(container.offsetWidth, container.offsetHeight);
        dots = buildDotGrid(p, BRANDON_CONFIG.dot);
        if (p.isLooping()) p.redraw();
      };
    };
  }

  function injectBackgrounds() {
    document.querySelectorAll('smp-section.brandon-p5-bg').forEach(section => {
      let type = 'haze-dark';
      if (section.classList.contains('ripple-wave')) type = 'wave';
      else if (section.classList.contains('haze-light')) type = 'haze-light';

      const bgDiv = document.createElement('div');
      bgDiv.className = 'brandon-bg-canvas';
      section.prepend(bgDiv);

      const sketch = (type === 'wave')
        ? createLoadWaveSketch(bgDiv)
        : createHazeSketch(bgDiv, type === 'haze-light' ? 'light' : 'dark');
      new p5(sketch, bgDiv);
    });
  }

  document.addEventListener('DOMContentLoaded', injectBackgrounds);
})();
