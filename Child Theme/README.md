# Brandon Child Theme Enqueue List

This child theme relies on the GSAP installation that ships with Semplice.
Only additional libraries needed by the custom animations are loaded.

## Enqueued Assets

- **brandon-custom-styles** – `style.css`
- **brandon-p5** – `p5.js` v1.9.4
- **brandon-gsap-ce** – GSAP `CustomEase` plugin v3.13.0
- **brandon-custom-scripts** – `brandon-custom-scripts.js`
  - Depends on `brandon-p5` and `brandon-gsap-ce`
  - Runs after Semplice’s core scripts (hook priority `20`)

GSAP core and other plugins are provided by the parent theme and are
not enqueued here.
