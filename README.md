[contributors-shield]: https://img.shields.io/github/contributors/hassan7303/add-category-in-order.svg?style=for-the-badge
[contributors-url]: https://github.com/hassan7303/add-category-in-order/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/hassan7303/add-category-in-order.svg?style=for-the-badge&label=Fork
[forks-url]: https://github.com/hassan7303/add-category-in-order/network/members
[stars-shield]: https://img.shields.io/github/stars/hassan7303/add-category-in-order.svg?style=for-the-badge
[stars-url]: https://github.com/hassan7303/add-category-in-order/stargazers
[license-shield]: https://img.shields.io/github/license/hassan7303/add-category-in-order.svg?style=for-the-badge
[license-url]: https://github.com/hassan7303/add-category-in-order/blob/master/LICENSE.md
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-blue.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://www.linkedin.com/in/hassan-ali-askari-280bb530a/
[telegram-shield]: https://img.shields.io/badge/-Telegram-blue.svg?style=for-the-badge&logo=telegram&colorB=555
[telegram-url]: https://t.me/hassan7303
[instagram-shield]: https://img.shields.io/badge/-Instagram-red.svg?style=for-the-badge&logo=instagram&colorB=555
[instagram-url]: https://www.instagram.com/hasan_ali_askari
[github-shield]: https://img.shields.io/badge/-GitHub-black.svg?style=for-the-badge&logo=github&colorB=555
[github-url]: https://github.com/hassan7303
[email-shield]: https://img.shields.io/badge/-Email-orange.svg?style=for-the-badge&logo=gmail&colorB=555
[email-url]: mailto:hassanali7303@gmail.com

[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![MIT License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url]
[![Telegram][telegram-shield]][telegram-url]
[![Instagram][instagram-shield]][instagram-url]
[![GitHub][github-shield]][github-url]
[![Email][email-shield]][email-url]


# add category in order

## Plugin Information

- **Plugin Name:** add category in order
- **Description:** Customizes the order page by categorizing products based otheir categories.
- **Version:** 1.0.0
- **Author:** Hassan Ali Askari
- **Author URI:** [Telegram](https://t.me/hassan7303)
- **Plugin URI:** [GitHub](https://github.com/hassan7303)
- **License:** MIT
- **License URI:** [MIT License](https://opensource.org/licenses/MIT)
- **Email:** hassanali7303@gmail.com
- **Domain Path:** [Domain](https://hsnali.ir)

## Features

- Adds a new "Order Categories" link to the WooCommerce "My Account" menu.
- Displays a list of all product categories.
- Shows products ordered by the customer in each category when a category is clicked.

## Installation

1. Download the plugin.
2. Upload the plugin folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.

## Usage

1. After activation, customers will see a new link called **"Order Categories"** in their "My Account" menu.
2. Clicking on this link will display a list of all product categories.
3. Clicking on a category will show the products ordered by the customer in that category.

## Code Structure

- **`add_custom_order_categories_link`**: Adds the "Order Categories" link to the "My Account" menu.
- **`add_custom_order_categories_endpoint`**: Registers the `order-categories` endpoint.
- **`display_custom_order_categories_page`**: Displays the order categories page and handles category-specific product listings.
- **`get_products_in_category_ordered_by_user`**: Retrieves products ordered by the user in a specific category.

## Requirements

- WordPress 5.0 or higher.
- WooCommerce 3.0 or higher.
- PHP 7.4 or higher.

## License

This plugin is released under the GPLv2 license. See the [LICENSE](LICENSE) file for details.


## اضافه کردن لینک سفارشات به منوی حساب من در وردپرس

این پلاگین یک صفحه‌ی جدید به بخش "حساب کاربری" ووکامرس اضافه می‌کند که به مشتریان امکان می‌دهد محصولات سفارش‌داده‌شده را بر اساس دسته‌بندی‌های محصول مشاهده کنند.

## ویژگی ها

 یک لینک جدید به نام "دسته‌بندی سفارشات" به منوی "حساب کاربری" ووکامرس اضافه می‌کند.

 لیست تمام دسته‌بندی‌های محصولات را نمایش می‌دهد.

 با کلیک روی هر دسته‌بندی، محصولات سفارش‌داده‌شده توسط مشتری در آن دسته‌بندی نمایش داده می‌شود.

## نصب

1- فایل‌های پلاگین را دانلود کنید و در پوشه‌ی `wp-content/plugins/custom-order-categories` قرار دهید.

2- به پیشخوان وردپرس بروید.

3- به مسیر **پلاگین‌ها > پلاگین‌های نصب‌شده** بروید.

4- پلاگین **Custom Order Categories** را فعال کنید.

5- به مسیر **تنظیمات > پیوندهای یکتا** بروید و روی **ذخیره تغییرات** کلیک کنید تا پیوندها به‌روزرسانی شوند.

## نحوه‌ی استفاده

1- پس از فعال‌سازی، مشتریان یک لینک جدید به نام **"دسته‌بندی سفارشات"** در منوی "حساب کاربری" خود مشاهده می‌کنند.

2- با کلیک روی این لینک، لیست تمام دسته‌بندی‌های محصولات نمایش داده می‌شود.

3- با کلیک روی یک دسته‌بندی، محصولات سفارش‌داده‌شده توسط مشتری در آن دسته‌بندی نمایش داده می‌شود.

## ساختار کد

- **`add_custom_order_categories_link`**: لینک "دسته‌بندی سفارشات" را به منوی "حساب کاربری" اضافه می‌کند.
- **`add_custom_order_categories_endpoint`**: endpoint جدید `order-categories` را ثبت می‌کند.
- **`display_custom_order_categories_page`**: صفحه‌ی دسته‌بندی‌های سفارشات را نمایش می‌دهد و محصولات مربوط به هر دسته‌بندی را مدیریت می‌کند.
- **`get_products_in_category_ordered_by_user`**: محصولات سفارش‌داده‌شده توسط کاربر در یک دسته‌بندی خاص را برمی‌گرداند.

## نیازمندی‌ها

 وردپرس نسخه ۵.۰ یا بالاتر.

 ووکامرس نسخه ۳.۰ یا بالاتر.

نسخه PHP ۷.۴ یا بالاتر.

## مجوز

این پلاگین تحت مجوز GPLv2 منتشر شده است. برای جزئیات بیشتر، فایل [LICENSE](LICENSE) را مشاهده کنید.
