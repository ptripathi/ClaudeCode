=== Village Connect — Unchdih ===
WordPress theme for Unchdih village website.
Village: Unchdih Bazar, Ramnagar, Prayagraj, Uttar Pradesh
Version: 1.0.0


------------------------------------------------------------
PRE-POPULATED CONTENT (auto-loads on theme activation)
------------------------------------------------------------

This theme comes with content pre-filled for Unchdih. When you
activate the theme in the WordPress Customizer (Appearance >
Customize), click "Publish" and WordPress will automatically create:

  Pages created:
    - Home          (static front page)
    - About Unchdih (village history, agriculture, education)
    - Culture & Festivals (Ram Leela, Kumbh, Holi, Chhath, Diwali)
    - News & Notices
    - Photo Gallery
    - Contact Panchayat

  Settings pre-filled:
    - Village Name:   Unchdih
    - District:       Prayagraj
    - State:          Uttar Pradesh
    - Tagline:        एक गाँव, अनेक कहानियाँ
    - Primary menu with all 6 pages linked

  Things you still need to fill in manually (Appearance > Customize
  > Village Information):
    - Exact population figure
    - Panchayat phone number
    - Panchayat email address
    - Facebook / YouTube / WhatsApp links (if any)
    - Hero banner photo (a landscape photo of the village)


------------------------------------------------------------
INSTALLING ON WORDPRESS (Live Site)
------------------------------------------------------------

Step 1 — Zip the theme
  On your computer, zip the entire "village-theme" folder.
  The zip file should be named: village-theme.zip

Step 2 — Upload to WordPress
  1. Log in to your WordPress admin panel (yoursite.com/wp-admin)
  2. Go to:  Appearance > Themes > Add New > Upload Theme
  3. Choose village-theme.zip and click "Install Now"
  4. Click "Activate"

Step 3 — Set the Homepage
  1. Go to:  Settings > Reading
  2. Set "Your homepage displays" to "A static page"
  3. Create a new page titled "Home" if you haven't already
  4. Select it as the Homepage

Step 4 — Fill in Village Details
  1. Go to:  Appearance > Customize > Village Information
  2. Fill in:
       - Village Name
       - Hero Tagline
       - Population, Area (sq km)
       - District, State
       - Panchayat Phone, Email, Address
       - Facebook URL, YouTube URL, WhatsApp Number
  3. Click "Publish" to save

Step 5 — Set the Hero Image (Banner Photo)
  1. Go to:  Appearance > Customize > Header Media
  2. Upload a wide landscape photo of your village (1920x1080 px recommended)
  3. Click "Publish"

Step 6 — Set Up Navigation Menu
  1. Go to:  Appearance > Menus > Create New Menu
  2. Add your pages (Home, About, Gallery, News, Culture, Contact)
  3. Set the display location to "Primary Navigation"
  4. Click "Save Menu"

Step 7 — Create Recommended Pages
  Create the following pages with these exact slugs (URL names):

  Page Title       Slug (URL)
  ---------------------------------
  About            about
  Gallery          gallery
  News             news
  Culture          culture
  Contact          contact

  The homepage will automatically pull content from these pages.

Step 8 — Contact Form (optional)
  Install a free form plugin such as:
    - WPForms Lite  (recommended)
    - Contact Form 7

  Add its shortcode to the "Contact" page content.
  The homepage contact section will display it automatically.

Step 9 — Give Editing Access to Others
  Go to:  Users > Add New

  Choose a role based on what the person should be able to do:

  Role          Can do
  -------------------------------------------------------
  Administrator All settings, themes, plugins, users
  Editor        Publish and edit all posts and pages
  Author        Write and publish their own posts only
  Contributor   Write posts, but needs Editor to publish


------------------------------------------------------------
RUNNING LOCALLY FOR TESTING (on your own computer)
------------------------------------------------------------

You need a local WordPress environment. The easiest free options are:

OPTION A — LocalWP (Recommended, no technical knowledge needed)
  Download: https://localwp.com

  1. Install and open LocalWP
  2. Click "+" to create a new site
  3. Enter any site name (e.g. "Village Test")
  4. Choose "Preferred" setup and click Continue
  5. Set a WordPress username and password, click "Add Site"
  6. Once created, click "Open Site Folder"
  7. Navigate to:  app > public > wp-content > themes
  8. Copy the entire "village-theme" folder into that "themes" folder
  9. Back in LocalWP, click "WP Admin" to open the admin panel
  10. Log in, then go to Appearance > Themes and activate Village Connect
  11. Follow Steps 3–9 from the "Installing on WordPress" section above

OPTION B — XAMPP (Windows/Mac/Linux)
  Download: https://www.apachefriends.org

  1. Install XAMPP and start Apache + MySQL from the control panel
  2. Download WordPress from wordpress.org and unzip into:
       Windows: C:\xampp\htdocs\village\
       Mac:     /Applications/XAMPP/htdocs/village/
  3. Open phpMyAdmin (http://localhost/phpmyadmin)
     Create a new database named: village_db
  4. Visit http://localhost/village and complete the WordPress setup wizard
  5. Copy "village-theme" folder into:
       wp-content/themes/
  6. Activate the theme from Appearance > Themes

OPTION C — DevKinsta (free, made by Kinsta)
  Download: https://kinsta.com/devkinsta/
  Similar workflow to LocalWP — create a site, then drop the theme
  folder into wp-content/themes/.


------------------------------------------------------------
UPDATING CONTENT AFTER INSTALLATION
------------------------------------------------------------

To add a News post:
  Posts > Add New — add title, content, featured image > Publish

To update the Gallery page:
  Pages > Gallery — add images using the Image or Gallery block in
  the Gutenberg editor. You can also embed YouTube videos by simply
  pasting the video URL on its own line.

To embed a YouTube or Vimeo video anywhere:
  In the Gutenberg editor, paste the video URL on a new blank line
  and press Enter. WordPress will auto-embed it.

To change the hero banner photo:
  Appearance > Customize > Header Media > Change Image


------------------------------------------------------------
SUPPORT
------------------------------------------------------------

Theme source code: https://github.com/ptripathi/ClaudeCode
