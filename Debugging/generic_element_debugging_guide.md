
# Generic Custom Element Debugging Guide

A portable checklist for debugging any custom code element (HTML/CSS/JS) in a CMS or page-builder environment.

## 1. Clarify the Issue
- Reproduce under real conditions (viewport, editor settings).
- Identify involved elements, their selectors, and properties.

## 2. Inspect a Working Reference
- Pick a native component that behaves correctly.
- In DevTools, record its computed:
  - display, align-self/align-items, justify-content
  - margin, padding
  - pseudo-element usage
  - media-query overrides

## 3. Diff Computed Styles
- Run a console script to compare computed styles:
  ```js
  (() => {
    const A = getComputedStyle(document.querySelector('#ref'));
    const B = getComputedStyle(document.querySelector('#custom'));
    const diffs = [];
    for (let p of A) {
      const vA = A.getPropertyValue(p), vB = B.getPropertyValue(p);
      if (vA !== vB) diffs.push({property: p, A: vA, B: vB});
    }
    console.table(diffs);
  })();
  ```
- Focus only on real differences.

## 4. Reset Custom Overrides
- Comment out all custom CSS/JS changes.
- Verify baseline behavior still shows the problem.

## 5. Apply Minimal Overrides
- Only implement the few differing properties:
  ```css
  .custom-module {
    display: inline-flex;
    align-self: center;
    margin-right: 16px;
  }
  ```
- Avoid blanket `!important` and deep container resets.

## 6. Verify & Iterate
- Hard-refresh, disable cache.
- Re-run diff script.
- Test across breakpoints.

## 7. Clean Up & Document
- Remove temporary code.
- Comment why each rule remains.
- Share this guide and your final snippets.

---

*Use this guide to keep overrides lean, targeted, and in harmony with the platform.*