# Project Overview

This project is a theme for the PipraPay platform, an open-source payment gateway. The theme is written in PHP and uses Bootstrap for styling. It provides a modern and responsive user interface for the checkout process, invoices, and payment links.

The project is divided into two main themes:

*   **Gateway Theme:** This theme handles the checkout process. It provides different views for each transaction status, such as "initialize," "pending," "completed," and "failed." It also includes an admin interface for configuring the theme's settings.
*   **Invoice Theme:** This theme is responsible for displaying invoices and payment links. It provides a clear and detailed view of the invoice, including the items, total amount, and payment status. It also includes a "Pay Now" button that allows users to pay their invoices directly.

## Building and Running

This is a theme for the PipraPay platform, so it doesn't have a build process of its own. To use this theme, you need to have a PipraPay installation.

1.  **Clone this repository.**
2.  **Upload the theme to your PipraPay installation.**
3.  **Activate the theme from your PipraPay admin panel.**

## Development Conventions

*   **File Structure:** The project follows a modular structure, with each theme located in its own directory. The `gateway` and `invoice` themes are further divided into `vercel` directories, which contain the core theme files.
*   **PHP:** The backend logic is written in PHP. The code is well-structured and uses functions to separate different functionalities.
*   **HTML and CSS:** The frontend is built with HTML and Bootstrap. The code is clean and easy to understand.
*   **JavaScript:** JavaScript is used for handling user interactions, such as form submissions and tabbed navigation. The project uses jQuery for AJAX requests.
*   **Views:** The theme uses separate view files for different UI components. This makes it easy to manage and customize the theme's appearance.
