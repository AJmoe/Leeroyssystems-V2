# Leeroy Systems — WordPress theme (v2)

A single, self-contained WordPress theme for the Leeroy Systems company site.
The layout is modelled on the Medksy clinic template and uses the Leeroy brand
(navy `#223258` plus a water-blue accent). All wording follows the Leeroy Systems Company Profile; photos and stories come from the
previous Leeroy Systems website.

Everything ships inside the theme: page content, images, forms, SEO tags.
It does not need Elementor, Contact Form 7, or a database import.


## Deploy on Render (temporary hosting)

This repository runs the full site in one Docker container, so Render can host
it straight from GitHub.

- The container uses WordPress with SQLite (WordPress's official SQLite
  Database Integration plugin), so it needs **no separate database**.
- On start it installs WordPress, activates the `leeroy-systems` theme, and
  builds all pages, the 9 news stories and the 16 gallery albums
  automatically. This takes about a minute after the first boot.

**One-time setup:**

1. In Render go to **New + → Blueprint** and connect this GitHub repository.
   Render reads `render.yaml` and creates a free Docker web service called
   `leeroy-systems`.
2. Click **Apply**. The first build takes a few minutes.
3. When it's live, open `https://<your-service>.onrender.com`. To log in to
   wp-admin, use user `admin` and the password Render generated, found under
   the service's **Environment** tab as `ADMIN_PASSWORD`.

Alternatively, create a **Web Service** manually, choose this repo, and set
**Runtime** to **Docker**. Render detects the `Dockerfile`.

**Optional settings** (service → Environment):

| Variable | Purpose |
| --- | --- |
| `SMTP_HOST`, `SMTP_PORT`, `SMTP_USER`, `SMTP_PASS`, `SMTP_FROM` | Lets the contact and careers forms send email. Without these the forms can't deliver. |
| `LEEROY_RECAPTCHA_SITEKEY`, `LEEROY_RECAPTCHA_SECRET` | reCAPTCHA v2 on the forms |
| `LEEROY_FB_ACCESS_TOKEN` | Facebook → News importer |
| `SITE_URL` | Only if you use a custom domain. Render's own URL is detected automatically. |

**Important: the free plan has no permanent disk.** When the service restarts
or redeploys (and free services sleep after 15 minutes idle), anything added
in wp-admin is lost: new posts, uploaded photos, edits. The theme's built-in
pages, news and gallery come back automatically every time. For the real site,
either attach a Render disk (paid plan; see the comment in `render.yaml`) or
install the theme on proper WordPress hosting as described below.

The site also asks search engines not to index it while it's on this
temporary address.

**Files:** `Dockerfile`, `docker/entrypoint.sh` (start-up and auto-install),
`docker/php.ini`, `docker/mu-plugins/leeroy-smtp.php` and `render.yaml`.

## What's here

- `leeroy-systems/` is the theme folder.
- `leeroy-systems.zip` is the same theme zipped, ready for **Appearance → Themes → Add New → Upload Theme**.

## Install

1. Start from any WordPress install: a fresh one, or the old site.
2. Upload `leeroy-systems.zip` (or copy the folder into `wp-content/themes/`) and click **Activate**.
3. That's it. On activation the theme creates all 11 pages (Home, Community,
   Careers, 4 service pages, 4 project pages) and sets Home as the front page.
4. Install **WP Mail SMTP** (or any SMTP plugin) so form emails actually deliver.
   The old site's Gmail SMTP settings work as-is.
5. Optional: to turn on reCAPTCHA v2, add these to `wp-config.php` (the old
   `WPCF7_RECAPTCHA_*` constants are also picked up automatically):
   ```php
   define( 'LEEROY_RECAPTCHA_SITEKEY', '...' );
   define( 'LEEROY_RECAPTCHA_SECRET',  '...' );
   ```

## Pages

| URL | Content |
| --- | --- |
| `/` | Hero slider, recognition highlights, about, six services, at-a-glance figures, vision & mission, values, technical capabilities + meter portfolio, track record, community, partners, contact forms, Africa → footprint → Botswana zoom map of offices and footprint countries |
| `/service-meters/` `/service-ciu/` `/service-engineering/` `/service-iot/` `/service-data/` `/service-software/` | Service detail with sidebar (the old `/service-network/` redirects to `/service-iot/`) |
| `/project-wuc/` `/project-jwaneng/` `/project-francistown/` `/project-palapye/` `/project-diphalane/` | Project detail with gallery + client, sector, scale and status |
| `/news/` | News stories (WordPress posts) with follow links to Facebook, LinkedIn and YouTube |
| `/gallery/` | Photo albums as folders, grouped into categories; `/gallery/?album=…` opens an album |
| `/community/` | Stats, filterable photo stories (lightbox galleries), YouTube videos |
| `/careers/` | Openings, why join, team photos, application form with CV upload |

## Forms

There are four forms: For Me, Business / Private, Sponsorship & Marketing, and
Careers (with a PDF/DOC/DOCX CV up to 5 MB). They all email
`info@leeroysystems.co.bw`, with Reply-To set to the sender. Each form has
nonce and honeypot spam protection, plus reCAPTCHA when it's configured.
Uploaded CVs are attached to the email and then deleted from the server.

## Header and offices map

- The header logo is `assets/img/logo.png`. It shows large at the top of the
  page and shrinks smoothly once the visitor scrolls down. The "Get In Touch"
  button is hidden while the logo is large and slides in once it shrinks.
- On tablets and phones the hamburger menu uses the original site's design: a
  small white button with three navy bars that opens a compact panel on the right.
- The **Our offices** section has one interactive map with three views:
  - **Africa:** the opening view.
  - **Footprint:** the map zooms here automatically when a visitor scrolls to it.
    It highlights Zambia, Namibia, Lesotho, Eswatini and Uganda with pins on
    their capitals (Lusaka, Windhoek, Maseru, Mbabane, Kampala), plus a
    Botswana "3 offices" pin.
  - **Botswana:** clicking the Botswana pin, or an office in the panel, zooms in
    to the Gaborone, Palapye and Francistown office pins.
- The Africa / Footprint / Botswana buttons in the panel switch between views.
  Hovering over or tapping any pin, office or country opens its card.
- To add or remove a footprint country, edit `leeroy_footprint()` in
  `inc/data.php`. The country outline and capital position also need adding
  to `inc/map-data.json`.
- The map outlines come from Natural Earth (public domain). They are stored
  ready to draw in `inc/map-data.json`, so the map doesn't load anything from
  outside the site.

## Content source

All wording follows the Leeroy Systems Company Profile (2026). That covers the
six services, at-a-glance figures, vision, mission, values, technical
capabilities, meter portfolio, track record, partners, social impact, and the
contact details and opening hours. When the profile changes, update
`inc/data.php`. If you add a page (for example a new service), bump
`LEEROY_PAGES_VERSION` in `functions.php` and the page is created
automatically on the next visit.

## Posting news

News uses WordPress's normal **Posts**, so there's nothing extra to install.

1. In wp-admin go to **Posts → Add New**.
2. Add a **title** and the story text. Photos, headings and quotes all work.
3. Set a **Featured image** in the right-hand panel. This is the cover photo on
   the News page and the image shown when the story is shared.
4. Optional: write a short **Excerpt** (the summary on the News page) and pick
   a **Category** (for example Projects, Training, Community or Awards).
5. Click **Publish**. The story appears at the top of `/news/` straight away.

Other notes:

- The newest story is shown large. The page lists 9 stories, with pagination
  for older ones.
- Delete WordPress's sample "Hello world!" post. The theme already hides it,
  but it's tidier to remove it.
- "Community" is no longer in the top menu, but the Community page still
  exists. It's linked from the home page and the footer.

## Managing the Gallery

The Gallery lives in the **News** menu (News → Gallery). It shows photo albums
as folders, grouped into four categories: **Events & visits**, **Life at
Leeroy**, **Training** and **Community outreach**. Opening an album shows its
photos, each with its own title, and every photo opens full size.

Albums are managed in the normal **Media Library**:

- **Add photos to an album:** go to **Media → Add New**, upload, then open each
  photo, type its **Title** (shown under the photo) and pick its album in the
  **Albums** field.
- **Create a new album:** go to **Media → Albums**, add the album name and
  choose one of the four categories as its **Parent**. You can also add a short
  description, which appears at the top of the album page.
- **Add a new category:** add an album with no parent. It appears under
  "More albums".
- **Album date and cover:** the first photo is the cover. Starter albums
  already have dates and covers.

Starter albums are built automatically in the background after installing
the theme: 16 albums with 112 photos, from the bundled news stories and the
Community page photo sets. Any bundled story added later with two or more
photos becomes an album automatically.

## Bundled news stories

Nine recent stories from the Leeroy Systems Facebook page ship inside the
theme (`inc/news-seed.php`, photos in `assets/img/news/`):

- LEA Board of Directors visit (11 Oct 2026, 11 photos)
- Nyangabgwe Hill wellness climb (10 Oct 2026, 5 photos)
- PENRESA / Forbes Africa flashback (9 Oct 2026)
- Botswana turns 60, we turn 11, with the Tuesday Grill feature (6 Oct 2026)
- Breast Cancer Awareness Month (5 Oct 2026)
- Boipuso: celebrating 60 years of independence (29 Sep 2026, 10 photos)
- Water Futures Dialogue, University of Botswana × Philipps-Universität Marburg (21 Sep 2026, 5 photos)
- Hosting GS1 Namibia, with thanks to LEA and BITC (4 Sep 2026, 4 photos)
- Sponsoring the inaugural Next Chapter Cup (about 10 Aug 2026, an estimate to confirm; 7 photos)

They're created automatically on the live site shortly after the theme is
installed. This happens in the background, or straight away when an admin
opens wp-admin. Their photos go into the Media Library, so you can edit the
stories like any other post. Deleting one is permanent: it won't come back.

## Importing news from Facebook automatically

The theme can bring posts from the Leeroy Systems Facebook Page into News by
itself, through Facebook's official Graph API. It needs a Page access token
from a Facebook admin of the page.

1. Get a long-lived Page access token. The steps are on the
   **Tools → Facebook News** screen in wp-admin.
2. Add it to `wp-config.php`:
   ```php
   define( 'LEEROY_FB_ACCESS_TOKEN', 'paste-token-here' );
   // Optional: publish straight away instead of saving drafts
   // define( 'LEEROY_FB_IMPORT_STATUS', 'publish' );
   ```
3. Go to **Tools → Facebook News** and click **Import from Facebook now**.
   After that the site checks for new posts every hour.

How imports behave:

- Imported posts arrive as **drafts** in the "Facebook" category, with the
  post photo as the cover image and a link back to the original post.
- Review them under **Posts** and publish the major ones. To publish
  automatically, set `LEEROY_FB_IMPORT_STATUS` to `publish`.
- A post is never imported twice, and edits you make in WordPress are kept.
  Photo-only posts and very short posts are skipped.

## Editing content

All text lives in `leeroy-systems/inc/data.php`: services, projects, values,
offices, partners, community stories, videos, contact details and SEO titles.
Images are in `leeroy-systems/assets/img/`. To add a project or service, add an
entry to the matching array in `data.php`, then reactivate the theme (or create
a page with the same slug).
