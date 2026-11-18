# Notimo – WordPress Plugin

**Show the right message at the right moment, on your website.**

[![Website](https://img.shields.io/badge/Website-notimo.online-blue)](https://notimo.online)
![Version](https://img.shields.io/badge/version-1.0.0-green)
![WordPress](https://img.shields.io/badge/WordPress-5.8%2B-blue)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple)
![License](https://img.shields.io/badge/license-GPLv2%2B-orange)

**Notimo** is a privacy-first, no-code on-site messaging platform that helps businesses communicate with website visitors through banners, notifications, and contextual messages.

The **Notimo WordPress Plugin** makes integrating Notimo into your WordPress website simple. Install the plugin, enter your license code, and manage your on-site messages directly from the Notimo dashboard.

No custom development. No complicated configuration. Just better communication with your visitors.

🌐 **Website:** https://notimo.online  
🚀 **Dashboard:** https://app.notimo.online

---

## ✨ Features

### Easy WordPress Integration
Connect your WordPress website to Notimo without manually modifying theme files or inserting JavaScript snippets.

### No-Code Message Management
Create, update, and manage on-site messages directly from the Notimo dashboard without developer assistance.

### On-Site Messaging
Display different types of messages, including:

- Promotional banners
- Website notifications
- Informational announcements
- Contextual messages
- Important website updates

### Smart Message Delivery
Use Notimo's messaging capabilities to display relevant messages at the right time and place.

### Privacy-First Approach
Notimo is designed with privacy in mind, focusing on contextual communication without relying on third-party tracking cookies or invasive visitor profiling.

### Simple License Configuration
Activate the Notimo SDK by entering your license code in the WordPress administration panel.

### Automatic SDK Integration
The plugin integrates the Notimo SDK into your website using the standard WordPress `wp_head` hook.

### Centralized Management
Manage your website messages from one dashboard without repeatedly updating WordPress content or modifying source code.

---

## 📋 Requirements

| Requirement | Version |
|-------------|---------|
| WordPress | 5.8 or higher |
| Tested up to | WordPress 6.6 |
| PHP | 7.4 or higher |
| Plugin Version | 1.0.0 |
| Notimo Account | Required |
| License Code | Required |

---

## 🚀 Installation

### Method 1: Manual Installation

1. Download the Notimo WordPress plugin.
2. Upload the `notimo` folder to your WordPress plugins directory:

   ```text
   /wp-content/plugins/notimo/
   ```

3. Log in to your WordPress administration panel.
4. Navigate to **Plugins → Installed Plugins**.
5. Find **Notimo** and click **Activate**.
6. Navigate to **Settings → Notimo**.
7. Enter your Notimo license code.
8. Click **Save Changes**.

Your WordPress website is now connected to Notimo.

### Method 2: Upload ZIP File

1. Download the plugin ZIP file.
2. Log in to your WordPress dashboard.
3. Navigate to **Plugins → Add New Plugin → Upload Plugin**.
4. Select the downloaded ZIP file.
5. Click **Install Now**.
6. Activate the plugin.
7. Open **Settings → Notimo**.
8. Enter and save your license code.

---

## ⚙️ Configuration

After activating the plugin, navigate to:

**WordPress Dashboard → Settings → Notimo**

Enter your license code and save your settings.

### SDK Behavior

The plugin automatically handles SDK integration based on your configuration.

| Configuration | Behavior |
|---------------|----------|
| Empty license code | Notimo SDK is disabled |
| License code provided | SDK integration is enabled |
| Public-facing WordPress pages | SDK is added to the page head |
| WordPress admin pages | No public-facing SDK injection |

### How It Works

The plugin uses the WordPress `wp_head` hook to insert the Notimo integration code into the HTML document's `<head>` section.

This eliminates the need to manually modify your WordPress theme.

**Note:** Your active WordPress theme must support the standard `wp_head()` function.

---

## 💡 How to Use Notimo

Once the plugin is installed and configured, you can manage your on-site messages through the Notimo dashboard.

### Step 1: Connect Your Website

Install the WordPress plugin and configure your license code.

### Step 2: Access Your Dashboard

Visit:

https://app.notimo.online

### Step 3: Create an On-Site Message

Create messages such as:

- A promotional banner announcing a special offer.
- A notification about an upcoming event.
- An informational message about a service update.
- A contextual message to guide visitors toward relevant content.

### Step 4: Configure Message Delivery

Configure your messages using the delivery and display options available in your Notimo dashboard.

### Step 5: Publish

Publish your message through Notimo.

Your website can now display the configured messages without requiring additional WordPress development.

---

## 🔒 Privacy & Security

Notimo is built around privacy-conscious website communication.

The Notimo platform emphasizes:

- Cookieless on-site messaging
- No third-party tracking cookies
- No invasive behavioral profiling
- Privacy-first architecture
- GDPR-oriented data protection practices
- Secure infrastructure hosted in the European Union

For more information, visit:

**Notimo Trust Center:** https://notimo.online/trust/

---

## 🔄 Updates

The plugin follows semantic versioning.

**Current Version:** `1.0.0`

Version numbers follow this structure:

```text
MAJOR.MINOR.PATCH
```

The plugin includes WordPress-compatible version and update metadata.

When distributed through a compatible WordPress update source, new versions can be installed through the standard WordPress plugin update interface.

---

## ❓ Frequently Asked Questions

### What is Notimo?

Notimo is an on-site messaging platform that allows businesses to create and display banners, notifications, and contextual messages without writing code.

### Do I need coding knowledge?

No. Once the WordPress plugin is installed and configured, messages can be managed from the Notimo dashboard.

### Does the plugin work on every page?

The plugin loads the Notimo SDK on public-facing WordPress pages when a license code is configured.

### What happens if the license code is empty?

The SDK remains disabled until a license code is provided.

### Do I need to modify my WordPress theme?

No. The plugin uses the standard WordPress `wp_head` hook to integrate the SDK.

### Can I manage messages without updating WordPress?

Yes. Messages are created and managed through the Notimo dashboard.

### Is Notimo free?

Notimo offers a free starting option. Visit https://notimo.online for more information.

### Does Notimo support privacy-conscious messaging?

Yes. Notimo is designed around privacy-first principles and avoids relying on invasive tracking practices.

---

## 🛠 Troubleshooting

### Notimo messages are not appearing

Check the following:

1. Make sure the plugin is activated.
2. Verify that your license code is saved under **Settings → Notimo**.
3. Confirm that your WordPress theme calls `wp_head()`.
4. Clear any WordPress or CDN caches.
5. Check that the Notimo SDK is being loaded.
6. Verify that your messages are published and their display conditions are satisfied.

### SDK is not loading

Make sure your license code field is not empty and your active theme supports the standard WordPress head hook.

### Messages are not updating

Check your message configuration in the Notimo dashboard and clear any relevant website caches.

---

## 📦 Plugin Information

| Property | Value |
|----------|-------|
| Plugin Name | Notimo |
| Contributors | notimo |
| Tags | notimo, sdk, head, script |
| Minimum WordPress Version | 5.8 |
| Tested WordPress Version | 6.6 |
| Minimum PHP Version | 7.4 |
| Stable Version | 1.0.0 |
| License | GPLv2 or later |

---

## 📄 License

This WordPress plugin is licensed under the **GNU General Public License v2.0 or later**.

See the [GNU GPL v2 License](https://www.gnu.org/licenses/gpl-2.0.html) for details.

---

## 🌍 About Notimo

Notimo helps businesses deliver relevant on-site messages without creating unnecessary technical complexity.

Our mission is to make website communication faster, simpler, and more privacy-conscious.

Whether you're announcing a promotion, sharing important information, or communicating with visitors at the right moment, Notimo gives you the tools to do it without relying on developers for every change.

**Focus on your message. Not on the code.**

### Useful Links

- 🌐 [Official Website](https://notimo.online)
- 🚀 [Notimo Dashboard](https://app.notimo.online)
- 🔒 [Trust Center](https://notimo.online/trust/)
- 🏢 [About Notimo](https://notimo.online/about/)

---

**Made with ❤️ by the Notimo Team**

© 2026 Notimo
