# Phu Yen University Theme (theme_pyu)

Modern international Moodle 5.1.1+ theme for Phu Yen University (Vietnam).

## Brand Colors

- **Primary Blue:** #3F4594
- **Primary Red:** #EF2B2D (accent for progress bars, danger)

## Features

- Boost-based (no core modification)
- Card-style UI with 14px rounded corners
- Soft shadows
- Gradient hero section on Dashboard, Site home, My courses
- Blue sidebar/drawer
- Red accent progress bars
- Fully responsive
- Production-ready SCSS

## Installation

1. Place the `pyu` folder in your Moodle `theme/` directory.
2. Visit **Site administration → Notifications** to complete the theme install.
3. Go to **Site administration → Appearance → Themes** and select "Phu Yen University".

## Compiling SCSS

To rebuild styles after customizing SCSS:

```bash
npx grunt sass --root=.
```

Or for theme only:

```bash
npx grunt sass:dist
```

## Configuration

**Site administration → Appearance → Themes → Phu Yen University**

- **Hero heading** – Main heading shown in the hero section (default: "Trường Đại học Phú Yên")
- **Hero subheading** – Tagline (default: "Phu Yen University - Excellence in Education")
- **Raw SCSS (pre)** – Custom SCSS injected before compilation
- **Raw SCSS** – Custom SCSS injected after compilation

## Structure

```
theme/pyu/
├── config.php           # Theme config
├── version.php
├── settings.php         # Admin settings
├── lib.php              # SCSS callbacks
├── layout/
│   └── drawers.php      # Layout with hero context
├── templates/
│   └── drawers.mustache # Template with hero block
├── scss/
│   └── preset/
│       ├── default.scss
│       └── pyu/
│           └── _overrides.scss
├── lang/
│   ├── en/theme_pyu.php
│   └── vi/theme_pyu.php
└── README.md
```

## Requirements

- Moodle 5.1.1+ (Build: 20260130)
- Parent theme: Boost
