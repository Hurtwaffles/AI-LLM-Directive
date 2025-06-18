# 🧠 AI GUIDE: Understanding Core Semplice 7 Theme Files

This directory contains a **minimal and structured subset** of the Semplice 7 theme, curated for **AI/LLM assistance in customizing** front-end behavior via CSS and JavaScript.

It is **not a full install**, but includes only the **key files** necessary to:
- Understand the structure of the theme
- Correctly hook into WordPress and Semplice behavior
- Inject custom animation, layout, and interaction logic safely

---

## 📁 Directory Overview

### 1. Core Theme Files (Required for Integration Context)

| File                        | Purpose                                                                 |
|-----------------------------|-------------------------------------------------------------------------|
| `functions.php`             | Enqueues scripts, defines theme features, registers hooks              |
| `style.css`                 | Theme metadata + default stylesheet (usually overridden via UI editor) |

> 🧠 AI Instruction: Look here to **register custom scripts**, **dequeue built-in conflicts**, or **add theme support** options.

---

### 2. Admin-Level Behavior (For Understanding Internal Tools)

| File              | Purpose                                              |
|-------------------|------------------------------------------------------|
| `functions.php`   | Internal admin-side logic for Semplice builder       |
| `grid.php`        | Controls layout/grid logic inside customization UI   |
| `transitions.php` | Defines transitions, animations used between pages   |
| `typography.php`  | Controls font settings mapped into inline CSS        |
| `webfonts.php`    | Manages imported webfonts via UI                     |

> 🧠 AI Instruction: Read to understand **how Semplice builds its page structure dynamically**, especially how CSS classes and inline styles are applied from the admin editor.

---

### 3. Theme Output Templates (To Target or Extend Layouts)

| File         | Purpose                                       |
|--------------|-----------------------------------------------|
| `header.php` | Top-level DOM wrapper + site head injection   |
| `footer.php` | Closes page and is often where JS loads       |
| `index.php`  | Base template for WordPress fallback routing  |
| `page.php`   | Template for standalone pages                 |
| `single.php` | Template for posts                            |

> 🧠 AI Instruction: Parse these to understand **where to insert custom markup, CSS classes, or script hooks**. This also helps target animations to specific sections or templates.

---

### ✅ 4. Optional but Useful (Understand Admin UI Hooks)

| File              | Purpose                                                 |
|-------------------|---------------------------------------------------------|
| `animate.php`     | Dialog logic for animation controls in UI               |
| `blocks.php`      | UI blocks configuration                                 |
| `core.php`        | Internal handling of shared admin elements              |
| `covers.php`      | Cover image/dialog logic                                |
| `media-library.php` | UI integration for media picker                      |
| `navigations.php` | Custom nav editor logic                                 |
| `post.php`        | Dialog and settings for post settings                   |
| `revisions.php`   | Version control integration for edits                   |
| `studio.php`      | External integration module                             |
| `webfonts.php`    | (Duplicate) for fallback font dialog parsing            |

> 🧠 AI Instruction: These are most useful for **LLMs modifying or generating admin panel interfaces**, **understanding customization flows**, or building tools that simulate theme editor behavior.

---

## 🧩 Recommended Usage Flow for AI Agents

1. **Start with `functions.php` in `Core Theme Files`** to identify hook points.
2. **Map front-end behavior from `header.php`, `footer.php`, and `page.php`**.
3. **If animation logic or layout classes are unclear**, reference:
   - `transitions.php`
   - `grid.php`
   - `typography.php`
4. **Use admin dialogs only if needed for UI extensions or internal debugging.**

---

## 🛠️ For Agents Injecting Custom JS/CSS

### Recommended Script Placement:
- Add JS/CSS enqueue logic in `functions.php` using:
  ```php
  wp_enqueue_script('my-script', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), null, true);
  wp_enqueue_style('my-style', get_stylesheet_directory_uri() . '/css/custom.css');
  ```

### Target Semplice-rendered content using:
- `.smp-section`, `.content-block`, or `.is-pinned` class wrappers
- Use `DOMContentLoaded` or `window.onload` to avoid race conditions

---

## 🔍 Version Control & File Edits

- Avoid editing these files directly in production themes.
- Use a **child theme** to override them cleanly.
- AI agents should document every change clearly and avoid destructive rewrites.

---

## 📎 Final Notes

- This package is **read-only** and meant to guide development—not to be deployed as-is.
- Be precise in parsing inline styles injected by Semplice; they often override external CSS.
- Check GSAP or SplitText-based animations for conflicts with Semplice's ScrollTrigger integrations.

---

> Created for AI tools like ChatGPT, GitHub Copilot, and Cursor to support custom Semplice builds.