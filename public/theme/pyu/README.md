# PYU Theme — Enterprise Design System for Moodle 5.x

Enterprise-level theme for PYU LMS, built on Moodle 5.1.1+ with a Canvas LMS–inspired, academic-first UI.

## Requirements

- Moodle 5.1.1+ (Build 20260130 or later)
- Parent theme: Boost (Moodle 5.x)
- Bootstrap 5
- PHP 8.1+

## Installation

1. Copy the `pyu` theme folder into `moodle/theme/`
2. Visit **Site administration → Notifications**
3. Click **Upgrade Moodle database now**
4. Go to **Site administration → Appearance → Themes → Theme selector**
5. Choose **Phu Yen University** as site theme
6. **Purge all caches** (Site administration → Development → Purge all caches)

## Purge caches

After any theme change:

- **Via UI:** Site administration → Development → Purge all caches  
- **Via CLI:** `php admin/cli/purge_caches.php`

## SCSS compilation

Moodle compiles SCSS when:

- Theme is upgraded
- Caches are purged
- Theme settings (e.g. colours) are saved

Manual compilation (if needed):

```bash
# From Moodle root
npx grunt amd
# Or for SCSS only (if your setup supports it)
php admin/cli/build_css.php
```

Preset SCSS is in:

- `theme/pyu/scss/preset/default.scss` – main preset

## Theme architecture

### 1. Moodle 5 structure

```
theme_pyu/
├── config.php           # Theme config
├── version.php
├── lib.php              # SCSS callbacks, pluginfile
├── settings.php         # Admin settings
├── layout/              # Layouts (inherits Boost, custom drawers)
│   └── drawers.php
├── templates/           # Mustache templates
│   ├── drawers.mustache
│   └── dashboard.mustache
├── scss/
│   ├── preset/default.scss
│   ├── tokens/          # Design tokens
│   └── components/      # Component overrides
├── classes/output/
│   └── core_renderer.php
└── lang/
```

### 2. Design tokens (SCSS)

Design system tokens:

- `scss/tokens/_colors.scss` – colours
- `scss/tokens/_spacing.scss` – spacing scale
- `scss/tokens/_typography.scss` – typography
- `scss/tokens/_elevation.scss` – shadows
- `scss/tokens/_radius.scss` – border radius

Tokens use CSS custom properties for theming and optional dark mode.

### 3. Layout

- Left course index drawer (240px desktop, collapsible)
- Top navbar (utility bar)
- Canvas-style hero on dashboard/frontpage
- Course index stays compatible with Moodle 5

### 4. Renderer overrides

`theme_pyu\output\core_renderer` extends `theme_boost\output\core_renderer`. Add overrides as needed, e.g.:

- `core_renderer` – breadcrumb, header, layout
- `core_course_renderer` – course output
- `core_block_renderer` – block output

### 5. Settings

- **Logo** – upload custom logo
- **Primary colour** – main brand colour
- **Hero heading/subheading** – dashboard hero text
- **Sidebar collapsed by default** – course index initial state
- **Enable dark mode** – dark mode toggle
- **Dashboard layout** – card grid vs list
- **Raw SCSS** – pre/post SCSS

## Development workflow

1. Edit SCSS under `scss/` and `scss/components/`
2. Purge caches (or save theme settings) to recompile
3. Use a local Moodle with theme designer mode for faster testing
4. Keep changes compatible with Moodle 5 and Boost

## Upgrade-safe practices

- Do not change core Moodle or Boost files
- Override via:
  - `templates/` (Mustache overrides)
  - `classes/output/` (renderer overrides)
  - `scss/components/` (CSS overrides)
- Prefer design tokens over hard-coded values
- Keep layout changes within Moodle 5 APIs

## Accessibility

- WCAG 2.1 AA contrast
- Focus states for keyboard users
- Semantic HTML and ARIA where applicable
- Reduced motion respected

## Browser support

- Current versions of Chrome, Firefox, Safari, Edge
- Mobile browsers (iOS Safari, Chrome for Android)
