# PrestaShop module skeleton

PrestaShop module skeleton used for version >= 1.7.1

## Getting Started

clone repository and add it to modules folder on a PrestaShop system

### Prerequisites

-   composer
-   PHP >= 7.1

### Installing

1. Change both module folder and main class name to your module name.
2. Find and replace on module scope all texts which starts with _Skeleton_ and _skeleton_ string to your module name.

-   MACOSX:
-   LC_ALL=C find . -type f -name '\*.\_' -exec sed -i '' s/skeleton/modulename/ {} +
-   LC_ALL=C find . -type f -name '\*.\_' -exec sed -i '' s/Skeleton/Modulename/ {} +

3. Execute _composer install_.
4. If module does not appear in the list, make sure name in the constructor matches the main file and folder name and also if folders have right permissions.
5. Install module.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
