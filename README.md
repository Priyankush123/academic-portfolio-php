**📚 Academic Portfolio CMS**

A custom-built PHP-based Content Management System (CMS) designed to manage and display academic profiles including research projects, publications, lectures, achievements, and more.

This system provides a secure admin panel with structured content management and a dynamic frontend for showcasing academic information.

**🚀 Features
🔐 Admin Panel**

Secure admin authentication
CSRF protection for all forms
Modular content management system

**📖 Academic Management**

Academic Qualifications
Research Projects (Major / Minor grouped)
Journal Publications (International / National grouped)
Conference Papers (International / National grouped)
Books (Published Books / Book Chapters)
Commentaries & Articles
Invited Lectures
Editorial Positions
ICT Teaching & Curriculum Development
Administrative Responsibilities & Trainings

**📝 Content Editing**

Rich text editing using Quill.js
Supports:
Bold, Italics
Lists
Paragraph formatting
Clean HTML rendering on frontend

**🖼️ Site Settings**

Profile Picture (DP) upload with:
File type validation (JPG, PNG, WEBP)
Size restriction (2MB)
Secure filename handling
Editable "About" section (Quill editor)

**📊 Additional Modules**

PDF management system
Access logs tracking
Blog & gallery management
Achievements module
**🛠️ Tech Stack**
Backend: PHP (PDO)
Database: MySQL
Frontend: HTML, CSS, JavaScript
Editor: Quill.js
Security: CSRF protection, input sanitization

**📂 Project Structure**

/admin
    academic.php
    achievements.php
    settings.php
    dashboard.php

/includes
    db.php
    admin_auth.php

/css
    style.css

/images
    (uploaded images)

/index.php

**⚙️ Installation**

1. Clone the repository
git clone https://github.com/your-username/academic-cms.git

3. Setup Database
4. 
Create a MySQL database
Import your tables:
qualifications
research_projects
dynamic_sections
conference_papers
invited_lectures
editorial_positions
achievements
site_settings

4. Configure Database

Edit:

/includes/db.php
$pdo = new PDO("mysql:host=localhost;dbname=your_db", "user", "password");
4. Run Project

Place in your server:

XAMPP / WAMP / LAMP
OR deploy to hosting

Access:

http://localhost/project/

Admin:

/admin/dashboard.php

**🔒 Security Features**

CSRF protection on all forms
Prepared statements (PDO)
XSS protection using htmlspecialchars()
Secure file uploads
Session-based admin authentication

**📌 Key Functional Concepts**

Dynamic Sections System
Uses a single table (dynamic_sections)
Controlled via:
section_key
subsection

Allows flexible content like:

Journals (International / National)
Books (Book / Chapter)
Commentaries
Content Rendering
Content Type	Rendering
Plain Text (textarea)	nl2br(htmlspecialchars())
Quill Content	Direct HTML render

**🎯 Use Case**

This CMS is ideal for:

Professors / Researchers
Academic portfolios
Institutional profiles
Research documentation platforms
✨ Future Improvements
Role-based admin system
Media manager
SEO optimization tools
API support
Export (PDF / CV generator)

**👨‍💻 Author**

Developed as a custom academic CMS system for structured content management and clean frontend display.

**📄 License**

This project is open-source and available under the MIT License.
