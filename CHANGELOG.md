# Changelog

Changes are grouped by release line. This repository-wide history covers all tags;
entries for another line do not change the compatibility of the installed package.
Historical notes were reconstructed from Git history. For pre-5.0 releases,
original non-merge commit subjects are retained with source links where available.
Dates are taken from the tag metadata (or the commit date for lightweight tags).

## 5.1.x

### [5.1.5] - 2026-11-10

- Moved release history from the README into a complete, tag-based changelog.
- Retained usage, upgrade instructions and current requirements in the README; no runtime or dependency changes.

### [5.1.4] - 2026-11-10

- Added the shared SVG package icon, README preview and Contao Manager logo documentation.
- Normalized licensing and source notices to LGPL-3.0-or-later.

### [5.1.3] - 2026-10-28

- Added bundled CSS styling for related tags.

### [5.1.2] - 2026-10-28

- Fixed tag copy and delete callbacks to use Doctrine DBAL. Added callback regression checks.

### [5.1.1] - 2026-10-28

- Added complete tag-extension translations for fourteen supported languages.

### [5.1.0] - 2026-10-28

- Added support for Contao 5.7 and PHP 8.3 or newer, removing the obsolete Contao Composer plugin dependency.
- Migrated all eleven bundled frontend templates to Twig while retaining their base names.
- Updated article and news rendering for Contao 5.7.
- Updated tag selection and cloud controls to work without MooTools or jQuery; made cloud toggle buttons keyboard-accessible.
- Improved filtering so multiple selected tags must all match and unmatched filters return no records. Aligned unpublished-content visibility with preview mode.
- Preserved existing tags and the database schema. Updated README compatibility and upgrade documentation.

## 5.0.x

### [5.0.10] - 2026-11-10

- Moved release history from the README into the same repository-wide, tag-based changelog used by the main branch.
- Retained usage, upgrade instructions and current requirements in the README; no runtime or dependency changes.

### [5.0.9] - 2026-11-10

- Added the shared SVG package icon, README preview and Contao Manager logo documentation.

### [5.0.8] - 2026-10-28

- Added bundled CSS styling for related tags in the Contao 5.3 line.

### [5.0.7] - 2026-10-28

- Applied the Doctrine DBAL fixes for tag copy and delete callbacks to the Contao 5.3 line.

### [5.0.6] - 2026-10-28

- Brought the improved tag filters, Twig templates and translations in fourteen languages to Contao 5.3.
- Adapted news archive pagination, including filtered totals, sorting and invalid-page handling.
- Retained existing tags and the database schema; documented verification with Contao 5.3.52.

### [5.0.5] - 2025-02-12

- Removed obsolete hook configuration and unused callback arguments; corrected a callback typo.
- Adjusted the minimum PHP requirement and package configuration.

### [5.0.4.2] - 2025-01-21

- Fixed namespace imports in event and FAQ modules and updated Composer configuration.

### [5.0.4.1] - 2024-12-02

- Added the missing sort order to tagged news lists.

### [5.0.4] - 2024-11-22

- Replaced legacy extraction of URL parameters.

### [5.0.3] - 2024-11-22

- Added a missing import.

### [5.0.2] - 2024-11-20

- Corrected namespace imports.

### [5.0.1] - 2024-11-19

- Fixed crashes when using pre-filtered lists.

### [5.0.0] - 2024-11-19

- Adapted the bundle for Contao 5.3, including API usage, namespace imports and query fixes.

## 4.9.x

### [4.9.16] - 2026-11-10

- Added the shared SVG package icon, README preview and Contao Manager logo documentation.

### [4.9.15] - 2024-06-04

- `Merged changes from origin` ([commit](https://github.com/hschottm/tags/commit/f1c2331f7da4a9372a61bcaecc18520f92089905)).
- `Removed an unused function` ([commit](https://github.com/hschottm/tags/commit/834719140e457fe52afad622c03fe0b1f93f5a5b)).
- `Fixed error that can occur with PHP 8 when a value is too short` ([commit](https://github.com/hschottm/tags/commit/b555a0ae2af5bf9364a5aa301a797311e863a8bd)).
- `Added missing assignments of template variables for a tag object list that were causing code crashes` ([commit](https://github.com/hschottm/tags/commit/7cf9b57489f043b9621598d7a89d2115fb15b8ed)).
- `Layout fix` ([commit](https://github.com/hschottm/tags/commit/d14f5c87fa64716561aee312cefbe04cebf9d815)).

### [4.9.14] - 2023-04-13

- `Added array key checks to prevent PHP warnings` ([commit](https://github.com/hschottm/tags/commit/9fde5ad783f40ecf59c7251d6db9ca577e2a430b)).
- `Removed an unused function` ([commit](https://github.com/hschottm/tags/commit/1121e894441085336aa766d29c8847b5f08418b9)).
- `Added default template variables to prevent crash in mod_tag_listbycategory` ([commit](https://github.com/hschottm/tags/commit/a72cec2d36d15f8653b200b04b5ada59a573f289)).
- `Fixed error that can occur with PHP 8 when a value is too short` ([commit](https://github.com/hschottm/tags/commit/8d476987e16159f2cca7bebbc8a73a0cdfec5dfe)).
- `Updated to Contao 4.13 FAQ list` ([commit](https://github.com/hschottm/tags/commit/2153603d1c27d3bb65b1306281a7b6b7056c74a5)).

### [4.9.13] - 2023-02-02

- Release integration snapshot with no additional non-merge commits since `4.9.12`.

### [4.9.12] - 2023-02-02

- `Fixed parent call of getAllEvents and added missing $blnFeatured parameter` ([commit](https://github.com/hschottm/tags/commit/6301b7e9380aa4053565cdb9c845dc9e0f0ea1c2)).

### [4.9.11] - 2022-12-20

- `Fixed an issue that page metadata wasn't changed for event detail pages` ([commit](https://github.com/hschottm/tags/commit/d9e1700293a884d87cc4973c473fef3392bcff40)).
- `Added default template variables to prevent crashes when using mod_tag_listbycategory` ([commit](https://github.com/hschottm/tags/commit/006fef7feec456cfac80b77286d37324427724ed)).

### [4.9.10] - 2022-11-28

- `Added default template variables to prevent crash in mod_tag_listbycategory` ([commit](https://github.com/hschottm/tags/commit/a72cec2d36d15f8653b200b04b5ada59a573f289)).

### [4.9.9] - 2022-11-24

- `Added missing SQL statement to FAQ tags` ([commit](https://github.com/hschottm/tags/commit/423ded4f4cc7db5a0c8a27a294a2a3f87ec510e7)).

### [4.9.8] - 2022-11-21

- `French translation (thanks to Renaud Kaczmarek)` ([commit](https://github.com/hschottm/tags/commit/85ce698960411c649eb27e89a50dc2e1b7b593b1)).
- `Added first version of French translation` ([commit](https://github.com/hschottm/tags/commit/cbca490bf1e621e9208a5074d2f6bb8ffbb10730)).

### [4.9.7] - 2022-11-21

- `Added related class for chosen related tags in all tag clouds.` ([commit](https://github.com/hschottm/tags/commit/48ab98966d8b3ca7bcd4b7a6c648dbfd81a56331)).

### [4.9.6] - 2022-11-03

- `Fixed a critical error calling getFrontendUrl` ([commit](https://github.com/hschottm/tags/commit/ef759f02354437ff2a52f966d07063efd939e793)).

### [4.9.5] - 2022-07-22

- `Extended tags_used insert tag with a parameter that will be printed when tags are used` ([commit](https://github.com/hschottm/tags/commit/993056189cc1734594949b3edd6bfcff15d2788e)).

### [4.9.4] - 2022-07-18

- `Added missing tables tl_faq and tl_files to global tags settings` ([commit](https://github.com/hschottm/tags/commit/35817cdf44c6807154ee1ed91385bd54ee0a5c5a)).
- `Fixed an error that can occur in PHP 8 when a value is too short` ([commit](https://github.com/hschottm/tags/commit/100a40177b9813c4c564c743bd02705724b149a1)).
- `Updated to Contao 4.13 FAQ list` ([commit](https://github.com/hschottm/tags/commit/2f341867d4670b96cf8be1f4b77e9783e6655e0e)).

### [4.9.3] - 2022-06-13

- `Fixed error that can occur with PHP 8 when a value is too short` ([commit](https://github.com/hschottm/tags/commit/8d476987e16159f2cca7bebbc8a73a0cdfec5dfe)).
- `Updated to Contao 4.13 FAQ list` ([commit](https://github.com/hschottm/tags/commit/2153603d1c27d3bb65b1306281a7b6b7056c74a5)).

### [4.9.2] - 2022-06-01

- `Updated to Contao 4.13 FAQ list` ([commit](https://github.com/hschottm/tags/commit/2f341867d4670b96cf8be1f4b77e9783e6655e0e)).

### [4.9.1] - 2022-06-01

- `Updated to Contao 4.13 FAQ list` ([commit](https://github.com/hschottm/tags/commit/2153603d1c27d3bb65b1306281a7b6b7056c74a5)).

### [4.9.0] - 2022-06-01

- `Added missing showTags template variable` ([commit](https://github.com/hschottm/tags/commit/55d341066cc5389e96c90d7e0c3f368d4e99c0b7)).
- `Removed session and cookie usages` ([commit](https://github.com/hschottm/tags/commit/913fa08fd22b9fdc50e540ec58aa1082d178fdeb)).
- `Changed callback calls to support Contao 4.13` ([commit](https://github.com/hschottm/tags/commit/2c626491b807f50013bea6ed1535f36946357b0b)).
- `file copy code` ([commit](https://github.com/hschottm/tags/commit/26e0897c547b64bd3a748f4d21fc090f9137ff16)).
- `Added missing import` ([commit](https://github.com/hschottm/tags/commit/1c73c37fa7275f3826044850dfbbb1058dc8a236)).
- `Changed callback, seems to have 3 paramaters in Contao 4.13` ([commit](https://github.com/hschottm/tags/commit/1232cf6d54a68a2b3a706dc751d7cb880e200181)).
- `Fixed typo` ([commit](https://github.com/hschottm/tags/commit/8c74616f4a0ad61265d84ddad832d37a3107b729)).
- `Callback test` ([commit](https://github.com/hschottm/tags/commit/ba3df120bd5078e4234cd4180d195585f4b531e6)).
- `Removed deprecated package` ([commit](https://github.com/hschottm/tags/commit/ec7b4d66c6f1985a3b66cab26d16bb8bb1905b97)).
- `Reverted back to module` ([commit](https://github.com/hschottm/tags/commit/64608250e717092a4432183e37cf4dadf0aa5b33)).
- `Fixed inheritance` ([commit](https://github.com/hschottm/tags/commit/fcbb5edbc8c9dc9d86409367e320b3a9000c3baa)).
- `Changed order` ([commit](https://github.com/hschottm/tags/commit/cf530c54a4b4acd312729802bee2b75bc59ebe40)).
- `Added class aliases` ([commit](https://github.com/hschottm/tags/commit/2cedbfeb2de5761d2413c10f4cad1ad8f1e371fa)).
- `Changed imports` ([commit](https://github.com/hschottm/tags/commit/88a29c4825e48788c70bd76f3fb373b2317d6be0)).
- `Removed imports` ([commit](https://github.com/hschottm/tags/commit/6d14664a6353d9d105760249d89111f424181782)).
- `Added dependencies` ([commit](https://github.com/hschottm/tags/commit/3319c05dbd00c78b015ed7895ec481850d42783c)).
- `Changed tags extension from module to bundle` ([commit](https://github.com/hschottm/tags/commit/0c357bbd7e9289165a4481b031913a201a7fc46f)).
- `PHP8 / Contao 4.13 fixes` ([commit](https://github.com/hschottm/tags/commit/86fe5f396b1cc4617a8c16629212bcb0c8f50cdd)).
- `[BUGFIX] Add static keyword to decode and encode function` ([commit](https://github.com/hschottm/tags/commit/1c767d3f8aada5870e61499fda799bf70daacd3f)).

## 4.6.x

### [4.6.7] - 2026-11-10

- Added the shared SVG package icon, README preview and Contao Manager logo documentation.

### [4.6.6] - 2023-03-07

- `Removed unused function with wrong syntax` ([commit](https://github.com/hschottm/tags/commit/5abd8a4cabb59cc4400f27f40f6fc8c242e34035)).
- `Fixed error calling addImageToTemplate of the content gallery` ([commit](https://github.com/hschottm/tags/commit/718d81036678fda6e8264b76b964b5de5eaf7a6b)).

### [4.6.5] - 2022-11-28

- `Added default template variables to prevent crash with mod_tag_listbycategory` ([commit](https://github.com/hschottm/tags/commit/1d3dda1ecf032200c383be995eb1c17f4c2e22bc)).
- `Merge changes from master` ([commit](https://github.com/hschottm/tags/commit/5c9637007bb9198bd3f958ba374b40dac5efe331)).
- `Added french translation` ([commit](https://github.com/hschottm/tags/commit/77e67d2b088d8e8438832c62a1edb250a2cc38b2)).
- `Fixed an error that can occur in PHP 8 when a value is too short` ([commit](https://github.com/hschottm/tags/commit/1207d4f016b1a5ca15e9ab15907b938a6ff8ff13)).
- `Added fixes for Contao 4.9` ([commit](https://github.com/hschottm/tags/commit/f5f2ba657e549caa23b430cea4f066b20742fb17)).
- `Fixed event reader crash by adding a private function from Contao source` ([commit](https://github.com/hschottm/tags/commit/a8029bfd42a200114c831e8f4f30cdf3797a8d5d)).
- `Removed Contao 4.10 call` ([commit](https://github.com/hschottm/tags/commit/ef48b9040483f5a1e7ba686213361edfb78cb9dc)).
- `Various compatibility fixes` ([commit](https://github.com/hschottm/tags/commit/a0c155f8a1cc1cfcf27893b090b605a1d8eed4d4)).
- `Replaced non existing Contao 4.10 calls to encode ampersands with PHP calls` ([commit](https://github.com/hschottm/tags/commit/a36e01ee8e386f1f2b003301cbce201502f27cd1)).
- `Added Contao version specific calls for Contao 4.9` ([commit](https://github.com/hschottm/tags/commit/10f1e053d85afc42eb6112b403911dca72f6ce9e)).
- `Added Contao version specific calls for Contao 4.8` ([commit](https://github.com/hschottm/tags/commit/a94c49cf275526237f154be8aefca53a379afd3a)).
- `Added Contao version specific calls for Contao 4.7` ([commit](https://github.com/hschottm/tags/commit/7a9d6e0dc33755eed3580f838429706143777232)).

### [4.6.4] - 2020-10-09

- `Added tags support for new internal/external news objects` ([commit](https://github.com/hschottm/tags/commit/6ee7b73e8bc028ddf087d95453ca7c8f5937fe5f)).
- `Fixed data storage for backend tag fields` ([commit](https://github.com/hschottm/tags/commit/92469a489a3feacdb040ae083db598e0f213940a)).

### [4.6.3] - 2020-09-25

- `Fixed event reader crash by adding a private function from Contao source` ([commit](https://github.com/hschottm/tags/commit/42c6fc8fad5ec1700b1b46ce20504a3d375fd6d1)).

### [4.6.2] - 2020-09-24

- `Added missing special char replacement to static tag class generation function` ([commit](https://github.com/hschottm/tags/commit/378ceda507cc8c5b0446e0b7f4b8eb6f8954a73a)).

### [4.6.1] - 2020-09-22

- `Update getAllEvents parameter declaration` ([commit](https://github.com/hschottm/tags/commit/cce967b738fd0a7c3fe2fdd02a14e419f27773a1)).
- `Update composer.json` ([commit](https://github.com/hschottm/tags/commit/0189d26615702c08b037993ed2198c8f821d955f)).
- `Replace öäüß& in class names` ([commit](https://github.com/hschottm/tags/commit/f57957a558d1bd3ba2f8dc8023c77ba7cbe88853)).
- `Replace all $objPage with correct page model object` ([commit](https://github.com/hschottm/tags/commit/2a172899adb11d7b498ff0b6032d9d6b454c288e)).
- `Add helper method, to get page id of jumpTo or global objPage` ([commit](https://github.com/hschottm/tags/commit/cb140e323b5241baaab2914caa39ed6946b3c4dd)).
- `Is this correct page object, or should it be tl_page.id = article.pid?` ([commit](https://github.com/hschottm/tags/commit/faf131e347fc824c30810b59836eedf90d385f5b)).

### [4.6.0] - 2020-09-14

- `Updated version requirements` ([commit](https://github.com/hschottm/tags/commit/b72c1df78d0d5ea60749e73086b317b7001eb44b)).
- `Prevent 'Warning: count(): Parameter must be an array or an object that implements Countable'` ([commit](https://github.com/hschottm/tags/commit/e6a34a1d240d017915e60b9ad8b922ce98b16059)).
- `https://github.com/hschottm/tags/issues/60` ([commit](https://github.com/hschottm/tags/commit/92952d8ee28ab6547e2dd1533fa69f2dd7fbd42f)).
- `Fix addImageToTemplate for contao 4.10` ([commit](https://github.com/hschottm/tags/commit/529d38f914b5e333eabce78f9446540a502caadf)).
- `Update ModuleTagCloud.php` ([commit](https://github.com/hschottm/tags/commit/8d39f8f47279f2c3835dc5be180a721b484d23c6)).

## 4.5.x

### [4.5.10] - 2026-11-10

- Added the shared SVG package icon, README preview and Contao Manager logo documentation.

### [4.5.9] - 2022-11-24

- `Merge changes from master` ([commit](https://github.com/hschottm/tags/commit/5c9637007bb9198bd3f958ba374b40dac5efe331)).

### [4.5.8] - 2022-11-21

- `Added french translation` ([commit](https://github.com/hschottm/tags/commit/77e67d2b088d8e8438832c62a1edb250a2cc38b2)).

### [4.5.7] - 2022-06-13

- `Fixed an error that can occur in PHP 8 when a value is too short` ([commit](https://github.com/hschottm/tags/commit/1207d4f016b1a5ca15e9ab15907b938a6ff8ff13)).

### [4.5.6] - 2022-06-01

- `Added fixes for Contao 4.9` ([commit](https://github.com/hschottm/tags/commit/f5f2ba657e549caa23b430cea4f066b20742fb17)).

### [4.5.5] - 2020-09-25

- `Fixed event reader crash by adding a private function from Contao source` ([commit](https://github.com/hschottm/tags/commit/a8029bfd42a200114c831e8f4f30cdf3797a8d5d)).

### [4.5.4] - 2020-09-23

- `Removed Contao 4.10 call` ([commit](https://github.com/hschottm/tags/commit/ef48b9040483f5a1e7ba686213361edfb78cb9dc)).

### [4.5.3] - 2020-09-23

- `Various compatibility fixes` ([commit](https://github.com/hschottm/tags/commit/a0c155f8a1cc1cfcf27893b090b605a1d8eed4d4)).
- `Replaced non existing Contao 4.10 calls to encode ampersands with PHP calls` ([commit](https://github.com/hschottm/tags/commit/a36e01ee8e386f1f2b003301cbce201502f27cd1)).
- `Added Contao version specific calls for Contao 4.9` ([commit](https://github.com/hschottm/tags/commit/10f1e053d85afc42eb6112b403911dca72f6ce9e)).
- `Added Contao version specific calls for Contao 4.8` ([commit](https://github.com/hschottm/tags/commit/a94c49cf275526237f154be8aefca53a379afd3a)).
- `Added Contao version specific calls for Contao 4.7` ([commit](https://github.com/hschottm/tags/commit/7a9d6e0dc33755eed3580f838429706143777232)).

### [4.5.2] - 2020-09-22

- `Update getAllEvents parameter declaration` ([commit](https://github.com/hschottm/tags/commit/cce967b738fd0a7c3fe2fdd02a14e419f27773a1)).

### [4.5.1] - 2020-09-18

- `Update composer.json` ([commit](https://github.com/hschottm/tags/commit/0189d26615702c08b037993ed2198c8f821d955f)).
- `Replace öäüß& in class names` ([commit](https://github.com/hschottm/tags/commit/f57957a558d1bd3ba2f8dc8023c77ba7cbe88853)).
- `Replace all $objPage with correct page model object` ([commit](https://github.com/hschottm/tags/commit/2a172899adb11d7b498ff0b6032d9d6b454c288e)).
- `Add helper method, to get page id of jumpTo or global objPage` ([commit](https://github.com/hschottm/tags/commit/cb140e323b5241baaab2914caa39ed6946b3c4dd)).
- `Is this correct page object, or should it be tl_page.id = article.pid?` ([commit](https://github.com/hschottm/tags/commit/faf131e347fc824c30810b59836eedf90d385f5b)).
- `Updated version requirements` ([commit](https://github.com/hschottm/tags/commit/b72c1df78d0d5ea60749e73086b317b7001eb44b)).

### [4.5.0] - 2020-09-15

- `Replaced non existing Contao 4.10 calls to encode ampersands with PHP calls` ([commit](https://github.com/hschottm/tags/commit/a36e01ee8e386f1f2b003301cbce201502f27cd1)).

## 4.4.x

### [4.4.3] - 2026-11-10

- Added the shared SVG package icon, README preview and Contao Manager logo documentation.

### [4.4.2] - 2020-09-25

- `Fixed event reader crash by adding a private function from Contao source` ([commit](https://github.com/hschottm/tags/commit/a6dc82482394a04b1f5b195d734e5bb043ff09e8)).

### [4.4.1] - 2020-09-23

- `Various compatibility fixes` ([commit](https://github.com/hschottm/tags/commit/5257ce1f9c6608f6d9cdb8c6c2d5f2c8a83ad1c9)).

### [4.4.0] - 2020-09-15

- `Replaced non existing Contao 4.10 calls to encode ampersands with PHP calls` ([commit](https://github.com/hschottm/tags/commit/8be5a08d882c69100c483d76ad10404310c111b1)).

## 4.3.x

### [4.3.1] - 2026-11-10

- Added the shared SVG package icon, README preview and Contao Manager logo documentation.

### [4.3.0] - 2020-09-15

- `Replaced non existing Contao 4.10 calls to encode ampersands with PHP calls` ([commit](https://github.com/hschottm/tags/commit/70f13142bcab0cafa96a3f0c42c85929eaaf5ec7)).

## 4.2.x

### [4.2.1] - 2026-11-10

- Added the shared SVG package icon, README preview and Contao Manager logo documentation.

### [4.2.0] - 2020-09-15

- `Replaced non existing Contao 4.10 calls to encode ampersands with PHP calls` ([commit](https://github.com/hschottm/tags/commit/19dadc247bdc9665c7f9b6466944ee08abcaa000)).

## 4.1.x

### [4.1.1] - 2026-11-10

- Added the shared SVG package icon, README preview and Contao Manager logo documentation.

### [4.1.0] - 2020-09-15

- `Replaced non existing Contao 4.10 calls to encode ampersands with PHP calls` ([commit](https://github.com/hschottm/tags/commit/95ffefb9b7729671645aee95e8b9059e6ced9c91)).

## 4.0.x

### [4.0.26] - 2026-11-10

- Added the shared SVG package icon, README preview and Contao Manager logo documentation.

### [4.0.25] - 2022-11-21

- `Added french translation` ([commit](https://github.com/hschottm/tags/commit/22bb53ea20269cd6649c454d4d85e95166b8b480)).

### [4.0.24] - 2020-09-23

- `Removed Contao 4.10 call` ([commit](https://github.com/hschottm/tags/commit/f579a48f3e0430286361f7838c544e254614fe31)).

### [4.0.23] - 2020-09-23

- `Various compatibility fixes` ([commit](https://github.com/hschottm/tags/commit/eaf8ba997ef0f57c723becf0b59201c64f3074b9)).

### [4.0.22] - 2020-09-15

- `Replaced non existing Contao 4.10 calls with PHP calls` ([commit](https://github.com/hschottm/tags/commit/d6b8eefd095c1bd8023b39dd0e85e8034f12a46c)).
- `Updated compatibility requirements` ([commit](https://github.com/hschottm/tags/commit/ec005f1a331a7b0ef8150d4895fcfa2d86104c43)).
- `Updated function calls based on Contao 4.4` ([commit](https://github.com/hschottm/tags/commit/caa2305176ad8672b0cb4e1dfb8b7b90ba82ffff)).

### [4.0.21] - 2020-09-14

- `Updated version requirements` ([commit](https://github.com/hschottm/tags/commit/b72c1df78d0d5ea60749e73086b317b7001eb44b)).

### [4.0.20] - 2020-09-14

- `Added Contao version specific calls for Contao 4.9` ([commit](https://github.com/hschottm/tags/commit/10f1e053d85afc42eb6112b403911dca72f6ce9e)).

### [4.0.19] - 2020-09-14

- `Added Contao version specific calls for Contao 4.8` ([commit](https://github.com/hschottm/tags/commit/a94c49cf275526237f154be8aefca53a379afd3a)).

### [4.0.18] - 2020-09-14

- `Added Contao version specific calls for Contao 4.7` ([commit](https://github.com/hschottm/tags/commit/7a9d6e0dc33755eed3580f838429706143777232)).

### [4.0.17] - 2020-09-14

- `Updated Contao version specific calls to Contao 4.6` ([commit](https://github.com/hschottm/tags/commit/77316c54032561fd2fccb2e04f21a3b1c360a228)).

### [4.0.16] - 2020-09-14

- `Updated Contao version specific calls to Contao 4.5` ([commit](https://github.com/hschottm/tags/commit/4de7551ccf2e5c4de0b34af0473932a0f6e27dba)).

### [4.0.15] - 2020-09-14

- `Updated compatibility requirements` ([commit](https://github.com/hschottm/tags/commit/ec005f1a331a7b0ef8150d4895fcfa2d86104c43)).
- `Updated function calls based on Contao 4.4` ([commit](https://github.com/hschottm/tags/commit/caa2305176ad8672b0cb4e1dfb8b7b90ba82ffff)).
- `Prevent 'Warning: count(): Parameter must be an array or an object that implements Countable'` ([commit](https://github.com/hschottm/tags/commit/e6a34a1d240d017915e60b9ad8b922ce98b16059)).
- `https://github.com/hschottm/tags/issues/60` ([commit](https://github.com/hschottm/tags/commit/92952d8ee28ab6547e2dd1533fa69f2dd7fbd42f)).
- `Fix addImageToTemplate for contao 4.10` ([commit](https://github.com/hschottm/tags/commit/529d38f914b5e333eabce78f9446540a502caadf)).
- `Update ModuleTagCloud.php` ([commit](https://github.com/hschottm/tags/commit/8d39f8f47279f2c3835dc5be180a721b484d23c6)).

### [4.0.14] - 2020-06-18

- `Generates wrong feeds xml` ([commit](https://github.com/hschottm/tags/commit/ce257d1c2dfce58330d24bd0573a6798e9a863d0)).
- `Sorting for Module NewsList added` ([commit](https://github.com/hschottm/tags/commit/4d2eb182f4bff165e3a3a4efe8303a999aea4035)).

### [4.0.13] - 2020-02-28

- `Updated core bundle requirements for new version` ([commit](https://github.com/hschottm/tags/commit/1fb5b937bc96a9c873d9c80f4a16e8eefe1e2537)).
- `Fixed settings class to deal with missing tl_settings class in Contao 4.9` ([commit](https://github.com/hschottm/tags/commit/4b2f8ba80e9862c5189178940aad271bb5f2786d)).

### [4.0.12] - 2019-11-26

- `Removed creation of non-existing DCA palettes which caused problems in the backend opening some subpalettes` ([commit](https://github.com/hschottm/tags/commit/936be13afd5fddaea9fcd11e5ff123f0bc1c6e3f)).
- `Removed comments` ([commit](https://github.com/hschottm/tags/commit/ebd99afbf3f8b3c66940ec9d5d19e861f2c7fe07)).
- `Added special encoding for tags with a slash inside the name` ([commit](https://github.com/hschottm/tags/commit/ba4b57ff597d9f1f07b698fd129dc1653c52b989)).
- `Removed explicit url encoding of tags to prevent a duplicate urlencoding caused by generateFrontendUrl` ([commit](https://github.com/hschottm/tags/commit/416a31e1dae4adbaf584b1ecfcd4ba773f2bd063)).
- `Removed all 'old' aurealis-links and mail addresses` ([commit](https://github.com/hschottm/tags/commit/f97eceb8b6b86adc64a385c6a8775ca3b5e55092)).
- `Fixed getTemplateGroup call that changed with Contao 4.8` ([commit](https://github.com/hschottm/tags/commit/762071795f9c2675a709c425bc79a539e3fdd557)).

### [4.0.11] - 2019-05-06

- `Removed deprecated constant` ([commit](https://github.com/hschottm/tags/commit/45464754c441b60031ff54ebafeffd5624aaa405)).
- `Removed old xhtml templates` ([commit](https://github.com/hschottm/tags/commit/19d0b9b481938ddf95b8508232e6d8bdec1819e5)).
- `Update mod_article_tags.html5` ([commit](https://github.com/hschottm/tags/commit/33365e03d28f55ac2983ea5b0f95d9acab25ee02)).

### [4.0.10] - 2018-06-20

- `Fixed wrong database field names` ([commit](https://github.com/hschottm/tags/commit/fbbc0d95c73787d6b828f74f18753d8b211913ad)).
- `Update README.md` ([commit](https://github.com/hschottm/tags/commit/76c20d983dbbbe479f58425c9a1d033225d6f25b)).

### [4.0.9] - 2018-03-19

- `Fixed getRelatedTagList and getTagList function headers` ([commit](https://github.com/hschottm/tags/commit/a6bf3f10ce8ea1c427db4c28d99a3907b0c1e5d4)).

### [4.0.8] - 2018-03-17

- `Moved additional tags_articles, tags_content, tags_events, tags_members and tags_news into the tags extension` ([commit](https://github.com/hschottm/tags/commit/dafbfae1bb5ef6387809ea072810e9c8a794ea48)).

### [4.0.7] - 2018-01-22

- `Fixed Internal Server Error when event alias wasn't found` ([commit](https://github.com/hschottm/tags/commit/257964d27d630526505f97dba98bcd5d1a1b315f)).

### [4.0.6] - 2017-12-15

- `Fixed backend classes` ([commit](https://github.com/hschottm/tags/commit/ee92787e273ef789be3f7b65455a3ab407515d2c)).

### [4.0.5] - 2017-12-15

- `Added missing css format` ([commit](https://github.com/hschottm/tags/commit/7864f978e1b35c26f2f2549e66d17305fb98002a)).

### [4.0.4] - 2017-12-14

- `Added missing parameter in function call` ([commit](https://github.com/hschottm/tags/commit/c2ab2ab7f52badb40dafb2ef9b8b9160ab908d3a)).
- `Changed overwritten code in classes according to Contao 4.4.x` ([commit](https://github.com/hschottm/tags/commit/f5c5598816be244dfb226b4f74d6aebae8e15077)).

### [4.0.3] - 2017-12-14

- `Update composer.json` ([commit](https://github.com/hschottm/tags/commit/44ad27fee731881f00f778e25067541708cbcda1)).

### [4.0.2] - 2017-12-14

- `Update composer.json` ([commit](https://github.com/hschottm/tags/commit/a2bc610579d53ec654968da80dd2a1292d64b0d2)).

### [4.0.1] - 2017-12-14

- `Versioning` ([commit](https://github.com/hschottm/tags/commit/7e2e9777bfb6936be7fa506405b77f9f84717de7)).

### [4.0.0] - 2017-12-14

- `Edited version numbers` ([commit](https://github.com/hschottm/tags/commit/064811fc6ef8938eb39114fbcbe9357d6bf8ea0e)).
- `Updated module name` ([commit](https://github.com/hschottm/tags/commit/f5146d9739813906934354e3728441a6db1f4746)).
- `Added missing function` ([commit](https://github.com/hschottm/tags/commit/f67367363683ce0adc0f7adcd4ce98f41922d3b2)).

## 3.5.x

### [3.5.3] - 2026-11-10

- Added the shared SVG package icon, README preview and Contao Manager logo documentation.

### [3.5.2] - 2017-07-27

- `Updated Contao code based on 3.5.28` ([commit](https://github.com/hschottm/tags/commit/a2f66067b004da38167dd0f9b32499772d6e48a8)).
- `Used current version of EventReader (3.5.28)` ([commit](https://github.com/hschottm/tags/commit/db5fed55d621e5b9b354b7adfce37af3ec576d3c)).
- `Fixed an issue showing the content of an event in the event reader` ([commit](https://github.com/hschottm/tags/commit/f59b411123fd69e7c7a70f7338b5ea52dc5f8ed9)).
- `Added composer.json` ([commit](https://github.com/hschottm/tags/commit/a117fdd2a95d1d68d8ddb7af36da787724269945)).
- `[*] Count variable` ([commit](https://github.com/hschottm/tags/commit/6e921ccda9c700245efe9ecd76cfee8b61d5653f)).
- `Add news image` ([commit](https://github.com/hschottm/tags/commit/cd29f3d862edaefb7a6e3942e3bfb5d1d870eebf)).
- `Fixed addEvent call to use the correct parameters in the overwritten function` ([commit](https://github.com/hschottm/tags/commit/b3135cb8fa427683ca15e6ab54581e210e17f2cb)).
- `Update ModuleTagListByCategory.php` ([commit](https://github.com/hschottm/tags/commit/ad7f797459ffe4dd9534db42f1543309cafc341a)).
- `Update mod_tag_listbycategory.xhtml` ([commit](https://github.com/hschottm/tags/commit/c3b77139c2774e7c1d64d5473808c4d3490eecfc)).
- `Update mod_tag_listbycategory.html5` ([commit](https://github.com/hschottm/tags/commit/6f6b1fd4b0f9664616c4c79204e7471075e68dff)).

### [3.5.1.1] - 2017-03-24

- `Fixed gallery element tags generation if there are not tags defined for a file` ([commit](https://github.com/hschottm/tags/commit/65de9ac87ca1a61e8bc5ef3d297e5f7d5a9a3e83)).

### [3.5.1] - 2017-03-24

- `Added tags to gallery image templates` ([commit](https://github.com/hschottm/tags/commit/75f25808b38b4766e7d1c56ae1dd77d2d87ac1b0)).

### [3.5] - 2016-12-26

- `Removed import for PHP7 compatibility` ([commit](https://github.com/hschottm/tags/commit/9c8d1b73d4f1350c64e8a51b3b93b2fe60c628ce)).
- `Fixed typo in SQL query for related tags` ([commit](https://github.com/hschottm/tags/commit/8a0b5ca1a67e32397d2964c39b5d3620587efb84)).

## 3.4.x

### [3.4a] - 2015-12-29

- Release integration snapshot with no additional non-merge commits since `3.4.3`.

### [3.4.3] - 2026-11-10

- Added the shared SVG package icon, README preview and Contao Manager logo documentation.

### [3.4.2b] - 2016-03-14

- `Added missing module connection` ([commit](https://github.com/hschottm/tags/commit/9c1542177793f784d37a6cf6cf8460171906eb91)).

### [3.4.2a] - 2016-03-14

- `Update README.md` ([commit](https://github.com/hschottm/tags/commit/5f9483c7436a68df7f8449968153e9bf0a4d097b)).
- `Updated license texts, added support for tags in calendars` ([commit](https://github.com/hschottm/tags/commit/930f23b59f7abe365a79589cfb9a853164271a3d)).

### [3.4.2] - 2016-03-07

- `Added support for tags in Calendar modules` ([commit](https://github.com/hschottm/tags/commit/fc0fea409bdcfcbff20cb8062c8ade566899e3c2)).
- `Added missing function which was accidentally removed with the last update` ([commit](https://github.com/hschottm/tags/commit/9a2c16096e5a3d0d193f7bd139210df7dd38db2f)).
- `Extended tag_filter field to 1000 characters` ([commit](https://github.com/hschottm/tags/commit/0521ef293bb58e8fea9eb09471cc61d41632ecb5)).

### [3.4.1] - 2016-01-03

- `Update README.md` ([commit](https://github.com/hschottm/tags/commit/4956da0381ba5f09e4502e505d583ad2d5f7f7a2)).
- `Changed maximum size of filter field from 255 to 1000 characters` ([commit](https://github.com/hschottm/tags/commit/82b92d555dc0c7c71b4ed431bc175110bbbf3a95)).
- `Removed templates` ([commit](https://github.com/hschottm/tags/commit/2e52fe0d998b0e65ea26a8b335566b4833c9d441)).

### [3.4] - 2015-12-29

- `Added compatibility with Contao 3.5` ([commit](https://github.com/hschottm/tags/commit/ec49a9b262df97c5e271f49252f09d79ead06463)).
- `Added related CSS style to related tags in tag clouds` ([commit](https://github.com/hschottm/tags/commit/d1b21de1048c2241d6b404183f36b15b9291a6cf)).

## 3.3.x

### [3.3.2] - 2026-11-10

- Added the shared SVG package icon, README preview and Contao Manager logo documentation.

### [3.3.1] - 2014-12-15

- `Fixed wrong calls of TagHelper class` ([commit](https://github.com/hschottm/tags/commit/79ed2ca717c5635de03fdbab92b21910089f3595)).
- `Fixed issue #11` ([commit](https://github.com/hschottm/tags/commit/0ba4f4eb8a2605272b4480c018f8f044a1eafb81)).
- `Removed file` ([commit](https://github.com/hschottm/tags/commit/a2595eb2cb939a0d194b441d8ad87f600629095a)).
- `Fixed .htacess` ([commit](https://github.com/hschottm/tags/commit/0b11264e0c35486b02fcbbddee8d95b727c57bed)).
- `Exclude tags of unpublished items (events, news ...) by default` ([commit](https://github.com/hschottm/tags/commit/185525e83eab927faf546114e2ae19dd05412592)).

## Legacy release labels

### [release/3.2.2] - 2014-01-15

- `Added tag output for event list and event reader` ([commit](https://github.com/hschottm/tags/commit/01f094c705b61ed8feabba4815989dea6a204456)).
- `Fixed issue #6: Fehlermeldung bei Nachrichten mit Contentelement Gallery` ([commit](https://github.com/hschottm/tags/commit/d3ad0a0adb2c865d5dca9d2ea2ff8b4534a84974)).

### [release/3.2.1] - 2014-01-15

- `Added more flexible approach for top tags. Made fixed number of 10 top tags configurable.` ([commit](https://github.com/hschottm/tags/commit/c7b0439ad4bdf4da2accf1ae6210cbd8fea49731)).
- `Added insert tags for file and faq` ([commit](https://github.com/hschottm/tags/commit/af7d984675e033b5d23a14f4257c3e2addb7bfa2)).

### [release/3.2.0b1] - 2013-11-08

- `Changed tag table struction to support Contao 3.2 model changes` ([commit](https://github.com/hschottm/tags/commit/ebbb3431a7c44d06e7e1c2fd330cf67499966496)).
- `Removed database file (no longer used)` ([commit](https://github.com/hschottm/tags/commit/767262647152782c7bc1c0ad0928111a7e9bf175)).

### [release/3.2.0] - 2013-11-26

- `Fixed urlencode problems for tags with spaces` ([commit](https://github.com/hschottm/tags/commit/f9721e10b754e61ece2a1204e484ae7b3f622ca2)).
- `Contao 3.2 fixes for gallery content` ([commit](https://github.com/hschottm/tags/commit/4c5a5b97e47ceaeaa198b07f90b2288a6e46d641)).

### [release/3.1.1-2] - 2013-11-26

- `Fixed problems with URL generation for tags with spaces` ([commit](https://github.com/hschottm/tags/commit/5b9319134a4cfe2745dd74c6db85d8af87037fb3)).
- `Merged latest changes` ([commit](https://github.com/hschottm/tags/commit/07bdd96cca287f2fd85087deb82e048bae7540b0)).

### [release/3.1.1] - 2013-11-07

- `Merge branch 'master' of https://github.com/hschottm/tags` ([commit](https://github.com/hschottm/tags/commit/4da264f29f414351ceccfc6294df4c0e7560e503)).

### [release/3.1.0] - 2013-11-01

- `Removed SQL statements from database file and moved statements to dca files` ([commit](https://github.com/hschottm/tags/commit/a91a154d5b88e029d2f096e2c8c5e5de63111ac2)).

### [legacy-contao-3.2-icon-1] - 2026-11-10

- Added the shared SVG package icon, README preview and Contao Manager logo documentation.

### [legacy-contao-3.1-icon-1] - 2026-11-10

- Added the shared SVG package icon, README preview and Contao Manager logo documentation.

### [legacy-contao-3.0-icon-1] - 2026-11-10

- Added the shared SVG package icon, README preview and Contao Manager logo documentation.

### [legacy-4.0-transition-icon-1] - 2026-11-10

- Added the shared SVG package icon, README preview and Contao Manager logo documentation.

### [Release_3_3_0] - 2014-06-19

- `Fixed crashes caused by missing template in Contao 3.3` ([commit](https://github.com/hschottm/tags/commit/5050eb2c2927f1e7e3c11036729d7f5a7add6b22)).
- `Fixed position of reducing the array, otherwise the relevance parameter would not be used correctly` ([commit](https://github.com/hschottm/tags/commit/2bdd983edcd39167309ec7fca424f736417e4446)).
- `Added tag cloud code which runs with Mootools and JQuery` ([commit](https://github.com/hschottm/tags/commit/4454e72d3106f67a63b6c28d21c484f0432529e1)).

[5.1.5]: https://github.com/hschottm/tags/releases/tag/5.1.5
[5.0.10]: https://github.com/hschottm/tags/releases/tag/5.0.10
[release/3.2.2]: https://github.com/hschottm/tags/releases/tag/release/3.2.2
[release/3.2.1]: https://github.com/hschottm/tags/releases/tag/release/3.2.1
[release/3.2.0b1]: https://github.com/hschottm/tags/releases/tag/release/3.2.0b1
[release/3.2.0]: https://github.com/hschottm/tags/releases/tag/release/3.2.0
[release/3.1.1-2]: https://github.com/hschottm/tags/releases/tag/release/3.1.1-2
[release/3.1.1]: https://github.com/hschottm/tags/releases/tag/release/3.1.1
[release/3.1.0]: https://github.com/hschottm/tags/releases/tag/release/3.1.0
[legacy-contao-3.2-icon-1]: https://github.com/hschottm/tags/releases/tag/legacy-contao-3.2-icon-1
[legacy-contao-3.1-icon-1]: https://github.com/hschottm/tags/releases/tag/legacy-contao-3.1-icon-1
[legacy-contao-3.0-icon-1]: https://github.com/hschottm/tags/releases/tag/legacy-contao-3.0-icon-1
[legacy-4.0-transition-icon-1]: https://github.com/hschottm/tags/releases/tag/legacy-4.0-transition-icon-1
[Release_3_3_0]: https://github.com/hschottm/tags/releases/tag/Release_3_3_0
[5.1.4]: https://github.com/hschottm/tags/releases/tag/5.1.4
[5.1.3]: https://github.com/hschottm/tags/releases/tag/5.1.3
[5.1.2]: https://github.com/hschottm/tags/releases/tag/5.1.2
[5.1.1]: https://github.com/hschottm/tags/releases/tag/5.1.1
[5.1.0]: https://github.com/hschottm/tags/releases/tag/5.1.0
[5.0.9]: https://github.com/hschottm/tags/releases/tag/5.0.9
[5.0.8]: https://github.com/hschottm/tags/releases/tag/5.0.8
[5.0.7]: https://github.com/hschottm/tags/releases/tag/5.0.7
[5.0.6]: https://github.com/hschottm/tags/releases/tag/5.0.6
[5.0.5]: https://github.com/hschottm/tags/releases/tag/5.0.5
[5.0.4.2]: https://github.com/hschottm/tags/releases/tag/5.0.4.2
[5.0.4.1]: https://github.com/hschottm/tags/releases/tag/5.0.4.1
[5.0.4]: https://github.com/hschottm/tags/releases/tag/5.0.4
[5.0.3]: https://github.com/hschottm/tags/releases/tag/5.0.3
[5.0.2]: https://github.com/hschottm/tags/releases/tag/5.0.2
[5.0.1]: https://github.com/hschottm/tags/releases/tag/5.0.1
[5.0.0]: https://github.com/hschottm/tags/releases/tag/5.0.0
[4.9.16]: https://github.com/hschottm/tags/releases/tag/4.9.16
[4.9.15]: https://github.com/hschottm/tags/releases/tag/4.9.15
[4.9.14]: https://github.com/hschottm/tags/releases/tag/4.9.14
[4.9.13]: https://github.com/hschottm/tags/releases/tag/4.9.13
[4.9.12]: https://github.com/hschottm/tags/releases/tag/4.9.12
[4.9.11]: https://github.com/hschottm/tags/releases/tag/4.9.11
[4.9.10]: https://github.com/hschottm/tags/releases/tag/4.9.10
[4.9.9]: https://github.com/hschottm/tags/releases/tag/4.9.9
[4.9.8]: https://github.com/hschottm/tags/releases/tag/4.9.8
[4.9.7]: https://github.com/hschottm/tags/releases/tag/4.9.7
[4.9.6]: https://github.com/hschottm/tags/releases/tag/4.9.6
[4.9.5]: https://github.com/hschottm/tags/releases/tag/4.9.5
[4.9.4]: https://github.com/hschottm/tags/releases/tag/4.9.4
[4.9.3]: https://github.com/hschottm/tags/releases/tag/4.9.3
[4.9.2]: https://github.com/hschottm/tags/releases/tag/4.9.2
[4.9.1]: https://github.com/hschottm/tags/releases/tag/4.9.1
[4.9.0]: https://github.com/hschottm/tags/releases/tag/4.9.0
[4.6.7]: https://github.com/hschottm/tags/releases/tag/4.6.7
[4.6.6]: https://github.com/hschottm/tags/releases/tag/4.6.6
[4.6.5]: https://github.com/hschottm/tags/releases/tag/4.6.5
[4.6.4]: https://github.com/hschottm/tags/releases/tag/4.6.4
[4.6.3]: https://github.com/hschottm/tags/releases/tag/4.6.3
[4.6.2]: https://github.com/hschottm/tags/releases/tag/4.6.2
[4.6.1]: https://github.com/hschottm/tags/releases/tag/4.6.1
[4.6.0]: https://github.com/hschottm/tags/releases/tag/4.6.0
[4.5.10]: https://github.com/hschottm/tags/releases/tag/4.5.10
[4.5.9]: https://github.com/hschottm/tags/releases/tag/4.5.9
[4.5.8]: https://github.com/hschottm/tags/releases/tag/4.5.8
[4.5.7]: https://github.com/hschottm/tags/releases/tag/4.5.7
[4.5.6]: https://github.com/hschottm/tags/releases/tag/4.5.6
[4.5.5]: https://github.com/hschottm/tags/releases/tag/4.5.5
[4.5.4]: https://github.com/hschottm/tags/releases/tag/4.5.4
[4.5.3]: https://github.com/hschottm/tags/releases/tag/4.5.3
[4.5.2]: https://github.com/hschottm/tags/releases/tag/4.5.2
[4.5.1]: https://github.com/hschottm/tags/releases/tag/4.5.1
[4.5.0]: https://github.com/hschottm/tags/releases/tag/4.5.0
[4.4.3]: https://github.com/hschottm/tags/releases/tag/4.4.3
[4.4.2]: https://github.com/hschottm/tags/releases/tag/4.4.2
[4.4.1]: https://github.com/hschottm/tags/releases/tag/4.4.1
[4.4.0]: https://github.com/hschottm/tags/releases/tag/4.4.0
[4.3.1]: https://github.com/hschottm/tags/releases/tag/4.3.1
[4.3.0]: https://github.com/hschottm/tags/releases/tag/4.3.0
[4.2.1]: https://github.com/hschottm/tags/releases/tag/4.2.1
[4.2.0]: https://github.com/hschottm/tags/releases/tag/4.2.0
[4.1.1]: https://github.com/hschottm/tags/releases/tag/4.1.1
[4.1.0]: https://github.com/hschottm/tags/releases/tag/4.1.0
[4.0.26]: https://github.com/hschottm/tags/releases/tag/4.0.26
[4.0.25]: https://github.com/hschottm/tags/releases/tag/4.0.25
[4.0.24]: https://github.com/hschottm/tags/releases/tag/4.0.24
[4.0.23]: https://github.com/hschottm/tags/releases/tag/4.0.23
[4.0.22]: https://github.com/hschottm/tags/releases/tag/4.0.22
[4.0.21]: https://github.com/hschottm/tags/releases/tag/4.0.21
[4.0.20]: https://github.com/hschottm/tags/releases/tag/4.0.20
[4.0.19]: https://github.com/hschottm/tags/releases/tag/4.0.19
[4.0.18]: https://github.com/hschottm/tags/releases/tag/4.0.18
[4.0.17]: https://github.com/hschottm/tags/releases/tag/4.0.17
[4.0.16]: https://github.com/hschottm/tags/releases/tag/4.0.16
[4.0.15]: https://github.com/hschottm/tags/releases/tag/4.0.15
[4.0.14]: https://github.com/hschottm/tags/releases/tag/4.0.14
[4.0.13]: https://github.com/hschottm/tags/releases/tag/4.0.13
[4.0.12]: https://github.com/hschottm/tags/releases/tag/4.0.12
[4.0.11]: https://github.com/hschottm/tags/releases/tag/4.0.11
[4.0.10]: https://github.com/hschottm/tags/releases/tag/4.0.10
[4.0.9]: https://github.com/hschottm/tags/releases/tag/4.0.9
[4.0.8]: https://github.com/hschottm/tags/releases/tag/4.0.8
[4.0.7]: https://github.com/hschottm/tags/releases/tag/4.0.7
[4.0.6]: https://github.com/hschottm/tags/releases/tag/4.0.6
[4.0.5]: https://github.com/hschottm/tags/releases/tag/4.0.5
[4.0.4]: https://github.com/hschottm/tags/releases/tag/4.0.4
[4.0.3]: https://github.com/hschottm/tags/releases/tag/4.0.3
[4.0.2]: https://github.com/hschottm/tags/releases/tag/4.0.2
[4.0.1]: https://github.com/hschottm/tags/releases/tag/4.0.1
[4.0.0]: https://github.com/hschottm/tags/releases/tag/4.0.0
[3.5.3]: https://github.com/hschottm/tags/releases/tag/3.5.3
[3.5.2]: https://github.com/hschottm/tags/releases/tag/3.5.2
[3.5.1.1]: https://github.com/hschottm/tags/releases/tag/3.5.1.1
[3.5.1]: https://github.com/hschottm/tags/releases/tag/3.5.1
[3.5]: https://github.com/hschottm/tags/releases/tag/3.5
[3.4a]: https://github.com/hschottm/tags/releases/tag/3.4a
[3.4.3]: https://github.com/hschottm/tags/releases/tag/3.4.3
[3.4.2b]: https://github.com/hschottm/tags/releases/tag/3.4.2b
[3.4.2a]: https://github.com/hschottm/tags/releases/tag/3.4.2a
[3.4.2]: https://github.com/hschottm/tags/releases/tag/3.4.2
[3.4.1]: https://github.com/hschottm/tags/releases/tag/3.4.1
[3.4]: https://github.com/hschottm/tags/releases/tag/3.4
[3.3.2]: https://github.com/hschottm/tags/releases/tag/3.3.2
[3.3.1]: https://github.com/hschottm/tags/releases/tag/3.3.1
