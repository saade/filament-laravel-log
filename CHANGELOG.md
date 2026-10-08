# Changelog

All notable changes to `filament-laravel-log` will be documented in this file.

## v4.2.0 - 2026-10-08

### Release Notes

* fix: rebuild the editor with Ace 1.44 and remove its listener on leave in [`3a466a8`](https://github.com/saade/filament-laravel-log/commit/3a466a8871cecbe2579d6eb28a2a29cd25a19fca)
* fix: survive missing directories, odd files and panels without the plugin in [`af98538`](https://github.com/saade/filament-laravel-log/commit/af98538cf0db3e451c00aacefd53b68688b822f1)
* fix: say what clearing does and tidy the translations in [`460b5e7`](https://github.com/saade/filament-laravel-log/commit/460b5e78233a6c52427f2082f7eac69a8665a78a)
* feat: support Filament 5 in [`503531e`](https://github.com/saade/filament-laravel-log/commit/503531e3bc3361566dc7912ba315cf2ed4d342e7)
* fix: only read and clear files the page lists in [`6246e5b`](https://github.com/saade/filament-laravel-log/commit/6246e5baabcd9463515eea1d7d1ca26fa6d2892d)

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v4.1.1...v4.2.0

## Unreleased

### Added

- Support for Filament 5, next to Filament 4.
- Compressed (`.gz`) log files are shown decompressed.

### Changed

- The file picker lists the most recently changed files first and shows each file by its path from the log directory, not its full path on the server.
- The confirmation for clearing says that it clears the selected file. It used to say "all site logs".
- The editor is built with Ace 1.44.

### Fixed

- The page only opens and clears the files it lists. A file excluded with `excludedFilesPatterns()`, a hidden file, or a path outside the log directories is refused.
- Log directories that are reached through a symbolic link, as on Envoyer, Deployer and Forge zero-downtime deployments, showed their files as empty ([#44](https://github.com/saade/filament-laravel-log/issues/44), [#52](https://github.com/saade/filament-laravel-log/issues/52)).
- Clearing is refused when the page is not clearable, not only hidden.
- In an application with several panels, the plugin failed with "Plugin [filament-laravel-log] is not registered for panel" when the default panel was not one that uses it, and every panel got the slug of the default panel's plugin ([#41](https://github.com/saade/filament-laravel-log/issues/41)).
- A log directory that does not exist broke the page. It is skipped now.
- A file that is not valid UTF-8 broke the page. Its invalid bytes are shown as `?`.
- A file that cannot be read or cleared shows a notification and no longer breaks the page.
- The Spanish translation had no navigation label, and the Persian one defined its navigation twice.
- The editor's listener is removed when the page is left, so it no longer piles up in panels with SPA mode.

## v4.1.1 - 2026-08-13

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v4.1.0...v4.1.1

## v3.3.0 - 2026-08-13

### What's Changed

* feat(lang): update fa files based on en for full coverage by @aboutnima in https://github.com/saade/filament-laravel-log/pull/51
* add german translation by @CyberLine in https://github.com/saade/filament-laravel-log/pull/49
* Add Portuguese language by @douglaswp in https://github.com/saade/filament-laravel-log/pull/53
* Add missing key to translations by @novadaemon in https://github.com/saade/filament-laravel-log/pull/42
* improve fa lang file 🇮🇷 by @alisalehi1380 in https://github.com/saade/filament-laravel-log/pull/50
* Laravel 13 support (3.x) by @edgrosvenor in https://github.com/saade/filament-laravel-log/pull/78

### New Contributors

* @aboutnima made their first contribution in https://github.com/saade/filament-laravel-log/pull/51
* @CyberLine made their first contribution in https://github.com/saade/filament-laravel-log/pull/49
* @douglaswp made their first contribution in https://github.com/saade/filament-laravel-log/pull/53
* @novadaemon made their first contribution in https://github.com/saade/filament-laravel-log/pull/42
* @alisalehi1380 made their first contribution in https://github.com/saade/filament-laravel-log/pull/50
* @edgrosvenor made their first contribution in https://github.com/saade/filament-laravel-log/pull/78

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v3.2.3...v3.3.0

## v4.1.0 - 2026-08-13

### What's Changed

* add german translation by @CyberLine in https://github.com/saade/filament-laravel-log/pull/49
* Add Portuguese language by @douglaswp in https://github.com/saade/filament-laravel-log/pull/53
* Add missing key to translations by @novadaemon in https://github.com/saade/filament-laravel-log/pull/42
* improve fa lang file 🇮🇷 by @alisalehi1380 in https://github.com/saade/filament-laravel-log/pull/50

### New Contributors

* @CyberLine made their first contribution in https://github.com/saade/filament-laravel-log/pull/49
* @douglaswp made their first contribution in https://github.com/saade/filament-laravel-log/pull/53
* @novadaemon made their first contribution in https://github.com/saade/filament-laravel-log/pull/42
* @alisalehi1380 made their first contribution in https://github.com/saade/filament-laravel-log/pull/50

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v4.0.0...v4.1.0

## v4.0.0 - 2025-10-02

### What's Changed

* Filament 4.x support by [@saade](https://github.com/saade) in [`72c6f4d`](https://github.com/saade/filament-laravel-log/commit/72c6f4da63099191845a607fe722c653fd6b72bb)
* Fix styling by [@saade](https://github.com/saade) in [`e1f95cd`](https://github.com/saade/filament-laravel-log/commit/e1f95cd25ce3a3791f304a07808ac3d9e67a082b)
* Update filament-laravel-log.php by [@aboutnima](https://github.com/aboutnima) in [`d3c6bfc`](https://github.com/saade/filament-laravel-log/commit/d3c6bfc2f811554ada0c32d5d5e9acfc3dd4c4e0)

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v3.2.3..v3.3.0

### New Contributors

* @aboutnima made their first contribution in https://github.com/saade/filament-laravel-log/pull/51

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v3.2.3...v4.0.0

## v3.2.3 - 2025-03-19

### What's Changed

* Laravel 12 Compatibility by @sweptsquash in https://github.com/saade/filament-laravel-log/pull/47
* Add italian language by @yaroslavpopovic in https://github.com/saade/filament-laravel-log/pull/46

### New Contributors

* @sweptsquash made their first contribution in https://github.com/saade/filament-laravel-log/pull/47
* @yaroslavpopovic made their first contribution in https://github.com/saade/filament-laravel-log/pull/46

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v3.2.2...v3.2.3

## v3.2.2 - 2024-05-17

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v3.2.0...v3.2.2

## v3.2.1 - 2024-03-13

### What's Changed

* Fix: Authorization lifecycle by @awcodes in https://github.com/saade/filament-laravel-log/pull/38

### New Contributors

* @awcodes made their first contribution in https://github.com/saade/filament-laravel-log/pull/38

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v3.2.0...v3.2.1

## v3.2.0 - 2024-03-12

Laravel 11.x Compatibility

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v3.1.0...v3.2.0

## v3.1.0 - 2024-03-03

### What's Changed

* Add ViewLog page customization
* Added 'limit' configuration in filament-laravel-log.php and updated... by @albertofuentes in https://github.com/saade/filament-laravel-log/pull/35

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v3.0.6...v3.1.0

## v3.0.6 - 2024-02-23

### What's Changed

* Add Spanish language by @albertofuentes in https://github.com/saade/filament-laravel-log/pull/36
* Add Dutch translation by @sitenzo in https://github.com/saade/filament-laravel-log/pull/33

### New Contributors

* @albertofuentes made their first contribution in https://github.com/saade/filament-laravel-log/pull/36
* @sitenzo made their first contribution in https://github.com/saade/filament-laravel-log/pull/33

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v3.0.4...v3.0.6

## v3.0.4 - 2024-01-30

### What's Changed

* chore(deps): bump stefanzweifel/git-auto-commit-action from 4 to 5 by @dependabot in https://github.com/saade/filament-laravel-log/pull/30
* Add Arabic Translation by @malzariey in https://github.com/saade/filament-laravel-log/pull/34

### New Contributors

* @malzariey made their first contribution in https://github.com/saade/filament-laravel-log/pull/34

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v3.0.3...v3.0.4

## v3.0.3 - 2023-10-04

### What's Changed

* chore(deps): bump actions/checkout from 3 to 4 by @dependabot in https://github.com/saade/filament-laravel-log/pull/26

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v3.0.2...v3.0.3

## v3.0.2 - 2023-09-07

### What's Changed

* Create Hungarian language by @gergo85 in https://github.com/saade/filament-laravel-log/pull/25

### New Contributors

* @gergo85 made their first contribution in https://github.com/saade/filament-laravel-log/pull/25

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v3.0.1...v3.0.2

## v3.0.1 - 2023-09-06

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v3.0.0...v3.0.1

## v1.2.3 - 2023-09-01

### What's Changed

* sort file desc by @nguyentranchung in https://github.com/saade/filament-laravel-log/pull/15

### New Contributors

* @nguyentranchung made their first contribution in https://github.com/saade/filament-laravel-log/pull/15

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v1.2.2...v1.2.3

## v3.0.0 - 2023-08-31

### What's Changed

* v3 support by @saade in https://github.com/saade/filament-laravel-log/pull/24

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v1.2.2...v3.0.0

## v1.2.2 - 2023-05-08

### What's Changed

- chore(deps): bump dependabot/fetch-metadata from 1.3.6 to 1.4.0 by @dependabot in https://github.com/saade/filament-laravel-log/pull/17
- add Persian language by @AmirAghaee in https://github.com/saade/filament-laravel-log/pull/18

### New Contributors

- @AmirAghaee made their first contribution in https://github.com/saade/filament-laravel-log/pull/18

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v1.2.1...v1.2.2

## v1.2.1 - 2023-03-20

### What's Changed

- 🐛 Should check if has selected log file before reading contents by @juliomotol in https://github.com/saade/filament-laravel-log/pull/14

### New Contributors

- @juliomotol made their first contribution in https://github.com/saade/filament-laravel-log/pull/14

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v1.2.0...v1.2.1

## v1.2.0 - 2023-02-21

### What's Changed

- Support for Laravel 10 by @ysfkaya in https://github.com/saade/filament-laravel-log/pull/13

### New Contributors

- @ysfkaya made their first contribution in https://github.com/saade/filament-laravel-log/pull/13

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v1.1.2...v1.2.0

## v1.1.2 - 2022-06-21

### What's Changed

- Bump dependabot/fetch-metadata from 1.3.0 to 1.3.1 by @dependabot in https://github.com/saade/filament-laravel-log/pull/4
- add:Sorting navigation items by @MilesWuCode in https://github.com/saade/filament-laravel-log/pull/7

### New Contributors

- @MilesWuCode made their first contribution in https://github.com/saade/filament-laravel-log/pull/7

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v1.1.1...v1.1.2

## v1.1.1 - 2022-04-02

## What's Changed

- fix: no authorization by default by @saade in https://github.com/saade/filament-laravel-log/pull/3

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v1.1.0...v1.1.1

## v1.1.0 - 2022-03-19

## What's Changed

- add authorization and multiple files support by @saade in https://github.com/saade/filament-laravel-log/pull/2

## New Contributors

- @saade made their first contribution in https://github.com/saade/filament-laravel-log/pull/2

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v1.0.1...v1.1.0

## v1.0.1 - 2022-03-18

**Full Changelog**: https://github.com/saade/filament-laravel-log/compare/v1.0.0...v1.0.1

## v1.0 - 2022-03-18

### Initial release v1.0

## 1.0.0 - 202X-XX-XX

- initial release
