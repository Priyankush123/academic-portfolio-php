<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once "includes/db.php";

/* Fetch PDFs */
$stmt = $pdo->query("SELECT id, title FROM pdfs ORDER BY uploaded_at DESC");
$pdfs = $stmt->fetchAll(PDO::FETCH_ASSOC);
/*
Expected session variables after login:
$_SESSION['user_id']
$_SESSION['user_email']
$_SESSION['is_admin']  // true / false
*/
$events = $pdo->query(
  "SELECT * FROM gallery_events
   ORDER BY year DESC, id DESC"
)->fetchAll(PDO::FETCH_ASSOC);

$blogs = $pdo->query(
  "SELECT id, title, summary, content, created_at
   FROM blogs
   ORDER BY created_at DESC"
)->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="index, follow">
    <meta
      name="description"
      content="Dr Amba Pande is a scholar of Diaspora and Migration Studies. She works with School of International Studes, Jawaharlal Nehru University, New Delhi"
    />
    <meta
      name="keywords"
      content="Amba Pande, Scholar, Indian Diaspora, Migration Studies"
    />
    <meta name="author" content="Dr. Amba Pande" />
    <meta name="robots" content="index, follow">

    <link rel="canonical" href="https://www.ambapande.in/">


    <title>Dr. Amba Pande | Academic Portfolio</title>

    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon.png">
    <link rel="shortcut icon" href="/favicon.png">
    <link rel="stylesheet" href="../css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">

    <script src="../js/script.js?v=<?= time() ?>"></script>
  </head>

  <body>
    <div id="blogOverlay" class="blog-overlay">
      <div class="blog-panel">
        <button class="close-panel" onclick="closeBlog()">← Back</button>

        <h1 id="panelTitle"></h1>
        <p class="panel-date" id="panelDate"></p>

        <div id="panelContent" class="panel-content"></div>
      </div>
    </div>
    <!-- ================= HEADER ================= -->
    <header class="header">
      <div class="header-left">
        <div class="dot"></div>
        <span class="name">Dr. Amba Pande</span>
        <span class="role">
           School of International Studies, JNU
        </span>
      </div>

      <button
        class="menu-toggle"
        id="menuToggle"
        aria-label="Toggle menu"
        aria-expanded="false"
      >
        ☰
      </button>

     <nav class="header-right" id="navMenu">
        <a href="#about">About</a>
        <a href="#awards">Awards</a>
        <a href="#publications">Publications</a>
        <a href="#major-projects">Projects</a>
        <a href="#gallery">Gallery</a>
        <a href="#contact">Contact</a>

        <?php if (isset($_SESSION['user_id'])): ?>

        <?php if (!empty($_SESSION['is_admin'])): ?>
        <a href="admin/dashboard.php" class="auth-link">Dashboard</a>
        <?php endif; ?>

        <a href="logout.php" class="auth-link">Logout</a>

        <?php else: ?>

        <a href="login.php" class="auth-link">Login</a>

        <?php endif; ?>
    </nav>

    </header>

    <!-- ================= HERO ================= -->
    <section class="main">
      <div class="image-container">
        <img src="images/dp.jpeg" alt="Dr. Amba Pande" />
      </div>

      <div class="content">
        <h1>Dr. Amba Pande</h1>
        <h3>Scholar of Diaspora & Migration Studies</h3>

        <p>
          Dr. Amba Pande is a scholar of Diaspora & Migration Studies and works
          as Documentation/Research Officer at the School of International
          Studies, Jawaharlal Nehru University, New Delhi.
        </p>

        <div class="buttons social-inline">

  <a href="https://www.linkedin.com/in/amba-pande-876a5652/"
     target="_blank"
     class="social-icon linkedin"
     aria-label="LinkedIn">
    <i class="fa-brands fa-linkedin-in"></i>
  </a>

  <a href="https://www.facebook.com/amba.pande"
     target="_blank"
     class="social-icon facebook"
     aria-label="Facebook">
    <i class="fa-brands fa-facebook-f"></i>
  </a>

  <a href="mailto:ambapande@gmail.com"
   class="social-icon gmail"
   aria-label="Email">
  <i class="fa-solid fa-envelope"></i>
 </a>
</div>
</div>
</section>
    <!-- ================= BLOG SECTION ================= -->
<section id="desk" class="section desk-compact">
  <h3 class="desk-title">From the Desk of Dr. Amba Pande</h3>
  <p class="desk-subtitle">
    Reflections on society, migration, and public discourse
  </p>

  <div class="desk-grid">

  <?php if (!$blogs): ?>
    <p style="opacity:.6;font-style:italic;">
      Blog posts will appear here once published.
    </p>
  <?php else: ?>
    <?php foreach ($blogs as $blog): ?>
     <article 
  class="desk-card"
  data-title="<?= htmlspecialchars($blog['title'], ENT_QUOTES) ?>"
  data-date="<?= htmlspecialchars(date("d M Y", strtotime($blog['created_at'])), ENT_QUOTES) ?>"
  data-content="<?= htmlspecialchars($blog['content'], ENT_QUOTES) ?>"
>
        <div class="desk-content">
          <h4><?= htmlspecialchars($blog['title']) ?></h4>
          <p><?= htmlspecialchars($blog['summary']) ?></p>
          <span class="desk-read">Read →</span>
        </div>
      </article>
    <?php endforeach; ?>
  <?php endif; ?>

  </div>
</section>



    <!-- ================= ABOUT ================= -->
    <section id="about" class="section">
      <h2>About</h2>

      <p>
        Dr. Amba Pande holds an M.Phil. and Ph.D. in International Studies from
        Jawaharlal Nehru University. She has contributed extensively to
        <b>research, teaching and academic programs </b>at the School of
        International Studies, JNU.
      </p>

      <p>
        Her research interests include the Indian Diaspora, international
        migration, transnationalism, and gender studies. Her work integrates
        <b>historical, political, sociological and Contemporary</b> perspectives
        to examine mobility and identity across global contexts.
      </p>
      <p>
        She is <b>Scholar of Migration & Diaspora Studies</b>. She works as a
        Documentation/Research Officer
        <b>at the level of Associate Professor</b>.
      </p>
    </section>
    <section id="qualifications" class="section">
      <h2>Academic Qualifications</h2>

      <ul class="styled-list">
        <li>
          <strong>Ph.D. (1999)</strong><br />
          CSCSEASWPS, School of International Studies, Jawaharlal Nehru University (JNU),
          New Delhi
        </li>

        <li>
          <strong>M.Phil. (1992)</strong><br />
          CSCSEASWPS, School of International Studies, Jawaharlal Nehru University (JNU),
          New Delhi
        </li>

        <li>
          <strong>M.A. in History (1988)</strong><br />
          University of Lucknow, Uttar Pradesh, India
        </li>

        <li>
          <strong>B.A. (1985)</strong><br />
          Vasanta College for Women (BHU), Krishnamurti Foundation, Varanasi, Uttar Pradesh, India
        </li>
        <li>
          <strong>10+2th</strong><br />
          Vasanta College for Women, Krishnamurti Foundation, Varanasi
        </li>
        <li>
          <strong>10th</strong><br />
          Rajghat Besant School Krishnamurti Foundation, Varanasi
        </li>
      </ul>
    </section>

    <!-- ================= RESEARCH PROFILE ================= -->
    <section id="profile" class="section">
      <h2>Academic & Research Profile</h2>

      <p>
        Dr. Pande has served as Visiting Faculty and Research Scholar at leading
        international institutions, including
        <b>Anton de Kom Universiteit van Suriname, Paramaribo, Suriname</b> ,
        <b> the University of Amsterdam (Netherlands)</b>,
        <b>the University of the South Pacific (Fiji)</b>, and
        <b>the University of Otago (New Zealand)</b>.
      </p>

      <p>
        She has led major research projects on the Indian Diaspora in Fiji,
        Myanmar, and Southeast Asia, sponsored by the Indian Council of Social
        Science Research (ICSSR), the University Grants Commission (UGC), and
        the Indian Council of Historical Research (ICHR).
      </p>
      
      <p>
          She taught courses such as History of Southeast Asia, Society and Politics in the Southwest Pacific, and Politics of Modern Southeast Asia at the MA and M.Phil levels. 
      </p>
      
      <h4 style="color:#2b4f81; margin-bottom:1px;">Membership of Research Bodies</h4>
      <ul>
          <li>Part of the Global Research Forum on Diaspora and Transnationalism (GRFDT) as Vice-President</li>
          <li>Member of the India International Society for Eighteenth-Century Studies (IISECS) as Vice-President</li>
          <li>Member of the Antar Rashtriya Sahyog Parishad (ARSP)</li>
      </ul>
    </section>
    <section id="awards" class="section">
  <h2>Awards & Recognitions</h2>

  <?php
  $awards = $pdo->prepare(
    "SELECT title, year FROM achievements
     WHERE type='award'
     ORDER BY year"
  );
  $awards->execute();
  ?>

  <?php foreach ($awards as $a): ?>
    <div class="achievement-item">
      <h4>
        <?= htmlspecialchars($a['title']) ?>
        <?php if (!empty($a['year'])): ?>
          (<?= htmlspecialchars($a['year']) ?>)
        <?php endif; ?>
      </h4>
    </div>
  <?php endforeach; ?>

</section>
<section id="major-projects" class="section">
      <h2>Completed Major Research Projects</h2>

      <ul class="styled-list">
        <li>
          <strong
            >India–Myanmar Relations and the Diaspora: Asset or
            Liability</strong
          >
          (2018–2020)<br />
          Sponsored by the Indian Council of Social Science Research (ICSSR),
          New Delhi
        </li>

        <li>
          <strong
            >Ethnic Conflict in Fiji: Challenges for the Indian Diaspora</strong
          ><br />
          Sponsored by the University Grants Commission (UGC), India
        </li>

        <li>
          <strong>India and its Diaspora in South East Asia</strong><br />
          ICSSR Fellowship (Two-year fellowship with full pay protection)
        </li>

        <li>
          Visiting Fellowship — Department of Business Economics, University of
          the South Pacific, Suva, Fiji (USP Fellowship, 2011)
        </li>

        <li>
          Visiting Fellowship — Department of Anthropology and Archaeology,
          University of Otago, Dunedin, New Zealand (2011)
        </li>

        <li>
          Indo-Dutch Visiting Fellowship (2005) — International Institute of
          Asian Studies, The Netherlands<br />
          <em>Project:</em> “The Role of the Indian Diaspora in
          India–Netherlands Relations”
        </li>
      </ul>

      <h2>Minor Research Projects & Research Grants</h2>

      <ul class="styled-list">
        <li>
          Research Grant (2003) — Indian Council for Historical Research
          (ICHR)<br />
          Field research on the Indian Diaspora in Fiji
        </li>

        <li>
          Research Grant (2003) — Ministry of External Affairs, Government of
          India<br />
          Field visits to Australia and Singapore to study the Indian Diaspora
        </li>
      </ul>
    </section>
    <section id="visiting-fellowships" class="section">
  <h2>Visiting Fellowships & Academic Appointments</h2>

  <?php
  $fellowships = $pdo->prepare(
    "SELECT title, year FROM achievements
     WHERE type='fellowship'
     ORDER BY year DESC, created_at DESC"
  );
  $fellowships->execute();
  ?>

  <?php foreach ($fellowships as $f): ?>
    <div class="achievement-item">
      <h4>
        <?= htmlspecialchars($f['title']) ?>
        <?php if (!empty($f['year'])): ?>
          (<?= htmlspecialchars($f['year']) ?>)
        <?php endif; ?>
      </h4>
    </div>
  <?php endforeach; ?>

</section>


    <section id="publications" class="section">
      <h2>Selected Journal Publications</h2>

      <details>
        <summary>(Click) View Publications in International Journals</summary>
        <ul>
          <li><strong>Feminization of Indian Migration: Patterns and Prospects was first published in the journal Asian and African Studies (Sage), Vol. 57, Issue 6, 2022. Citation-17. Translated in French and published in Alternatives Sud- Migrations, en tout- genre, Vol 30-2023. </strong></li>
          <li><strong>India and its Diaspora: Charting New Avenues of Engagement, International Studies, 54 (1–4) 180–195, 2018. </strong></li>
          <li><strong>Migration of Students from India and China: A Comparative View, South Asian Survey 23(1) 69–92, 2018, in co-authorship. Citations:13 </strong></li>
          <li><strong>Indians in Southeast Asia: Sojourns, settlers, Diasporas, International Studies, 51(1–4) 133–144, 2014. Citations: 7  </strong></li>
          <li><strong>Role of Diasporas in Homeland Conflicts/Conflict Resolution and Post-War Reconstruction: The Case of Tamil Diaspora and Sri Lanka, in South Asian Diaspora (Print ISSN: 1943-8192; Online ISSN: 1943-8184) Vol. 9, Issue 1, 2017, pp 51-66. Citation-33 </strong></li>
          <li><strong>India’s Experience with Remittances: A Critical Analysis. The Round Table, Vol . 107, No.1, 2018, pp 33-43. ISSN: 0035-8533 (Print) 1474-029X. Citations:17 </strong></li>
          <li><strong>India’s Act East Policy and ASEAN: Building a Regional Order Through Partnership in the Indo-Pacific (Co-authorship), International Studies 57(1) 67–78, 2020, 2019. Citation- 15.</strong></li>
          <li><strong>Skilled Immigration and Conditions for Labour Competition in the US: A Comparative Study of the Indian, the Mexican and the Chinese Diasporas (Co-authorship), Migration and Development (Print ISSN: 2163-2324 Online ISSN: 2163-2332), Vol 6, Issue 3,
2017, pp 343-354. Citation-11</strong>
</li>
          <li><strong>Diaspora Policies and Co-development: A Comparison between India, China and Mexico, forthcoming in Co-authorship in Migration Letters (ISSN: 1741-8984 | e- ISSN: 1741-8992), Volume: 14, No: 2, 2017 pp. 181 – 195 (in co-authorship) Citation-20.</strong></li>
          <li><strong>Role of Indian Diaspora in the Development of Indian IT Industry, Diaspora Studies
(Print ISSN: 0973-9572; Online ISSN: 0976-34570), Vol. 7, No.2,2014, pp.121-129.
Citation-43. </strong></li>
          <li><strong>Conceptualising Indian Diaspora: Diversities within a Common Identity, Economic & Political Weekly (ISSN 2349-8846) Vol.48, No 49, December 7, 2013, pp.59-65. Citation-50 </strong></li>
          <li><strong>India and Its Diaspora in Fiji, Diaspora Studies (Print ISSN: 0973-9572; Online ISSN: 0976-34570), Vol.4, No.2, 2011, pp 125-138. Citation-18</strong></li>
          <li><strong>Indians and the Struggle for Power in Fiji, Diaspora Studies (Print ISSN: 0973- 9572; Online ISSN: 0976-34570), Vol. 3 No1, Jan-Jun 2010, pp.57-68. Citation-4.</strong> </li>
          <li><strong>Race and Power Struggle in Fiji, Strategic Analysis, (ISSN: Print 0970-0161; Online 1754-0054), Vol. 24, No.6, September 2000, pp1155-1169. Citation-2.</strong> </li>
          <li><strong>Bose beyond the Mystery, Strategic Analysis, (ISSN: Print 0970-0161; Online 1754- 0054), Vol 40,  No. 4, 2016, pp.234-238. Citation-2.</strong> </li>
          <li><strong>India’s Act East Policy and ASEAN: Building a regional order through partnership in the Indo-Pacific. (Co-authored). International Studies Vol . 57, No.1, 2020, pp 67-78.  Citations -17.</strong>  </li>
          <li><strong>Book Review of N. Jayaram (ED), Diversities in the Indian Diaspora: Nature, Implications, Responses (New Delhi; Oxford University Press, 2011) Diaspora Studies (Print ISSN: 0973-9572; Online ISSN: 0976-34570), V0l.5, No.2,2012. Citations:4</strong> </li>
          <li><strong>Book Review of Meenakshi Thapan, ED. Transnational Migration and the Politics of Identity (New Delhi; Sage, 2005) was published in the October issue of Social Action: A Quarterly Review of Social Trends. </strong></li>
        </ul>
      </details>
      <details>
        <summary>(Click) View Publications in National-level Journals</summary>
        <ul>
          <li><strong>COVID-19 and the Distress Reverse Migration in India: A Gendered Perspective  </strong></li>
          <li><strong>India and the South Pacific: Moving Towards a Closer Partnership, FPRC JOURNAL Focus: India and Pacific Islands, 2018(1), Foreign Policy Research Centre New Delhi (India), pp 18-24. ISSN 2277 – 2464</strong></li>
          <li><strong>India and Pacific Islands Region: Building New Partnerships, Journal of Alternative Perspectives in the Social Sciences (ISSN: 1944-1096; ISSN-L:1944-1088), Vol 7, No.2, 2015, pp.284-289. Citations: 2 </strong></li>
          <li><strong>‘Airlift' and a Reflection on India's Diaspora Policy. Citations: 6  </strong></li>
        </ul>
      </details>
       </br>
       <p class="note">
          Click to Access Journals -- <a href="#pdf-library">Click here</a>
        </p>
        </br></br>
      <h2>Books & Edited Volumes</h2>

      <details>
        <summary>(Click) View Published Books</summary>
        <ul>
          <li>
            <strong>Migration and the Rise of the United States: The Role of Old and New Diasporas (co-edited), Edinburgh University Press, 2024. </strong>
          </li>
          <li>
            <strong>Women in the Indian Diaspora: Historical Narratives and Contemporary Challenges. (Edited) Singapore: Springer 2018</strong>
          </li>
          <li>
            <strong>Indentured and Post Indentured Experiences of the Women in the Indian Diaspora (Edited) Singapore: Springer Nature, 2020 ISBN-10: 9811511764, ISBN-13: 978-
9811511769
</strong>
          </li>
          <li>
            <strong>Women, Gender and the Legacy of Slavery and Indenture (co-edited) (UK: Routledge). 2021. ISBN 9780367676230. </strong>
          </li>
          <li>
            <strong>Regional Security in Southeast Asia and the South Pacific: Prospects of Nuclear Free Zone (New Delhi: Authors Press, 2002)</strong>
          </li>
          <li><strong>Interrogating Diasporas and Diasporic identities: The case of the Indian Diaspora in Fiji (Forthcoming with Routledge, UK).</strong></li>
        </ul>
      </details>
      <details>
        <summary>(Click) View Published Book Chapters</summary>
        <ul>
          <li>
            <strong>Women and Indenture: Revisiting Indian Discourses in Judith Misrahi-Barak, Ritu Tyagi, et al. (Eds.) Kala Pani Crossings, Gender and Diaspora: Indian Perspectives.</strong>
          </li>
          <li>
            <strong>Indentured and Post-Indentured Indian Women: Changing Paradigms and Shifting Discourses in Amba Pande (Eds) Indentured and Post-Indentured Indian Experience of Women in the Indian Diaspora (Singapore; Springer, 2020). </strong>
          </li>
          <li>
            <strong>Female Migration from India: Trends and Continuing Challenges in Towards a Changing International Migration and Mobility Agenda: The Indian Perspective, ICWA, New Delhi, 2025. 
</strong>
          </li>
          <li>
            <strong>Regional Challenges and International Relations: The Complex Realities of South Pacific Geopolitics. Global Maritime Geopolitics, Edited by Hasret Çomak, Burak Şakir Şeker, and Mehlika Özlem Ultan. </strong>
          </li>
          <li>
            <strong>Women in the Indian Diaspora: Redefining Self between Dislocation and Relocation in Amba Pande (Ed.), Women in the Indian Diaspora: Historical Narratives and Contemporary Challenges (Singapore: Springer, 2018).</strong>
          </li>
          <li><strong>Factoring Transnational Diasporas in the Rise of the US as a Great Power and a Multi-Cultural Society (co-authored) in Amba Pande & Camelia Tigau (Eds.) Migration and the Rise of the United States: The Role of Old and New Diasporas. Edinburgh University Press 2024. </strong></li>
          <li><strong>The Labelling of Migrants and Diasporas in the US Media and Policy: A Historical Sketch(co-authored) in Amba Pande & Camelia Tigau (Eds.) Migration and the Rise of the United States: The Role of Old and New Diasporas. Edinburgh University Press 2024.</strong></li>
          <li><strong>An Everlasting Endowment: Insights From a Multi-Dimensional Analysis of Migration and Diasporas in the US (co-authored) in Amba Pande & Camelia Tigau (Eds.) Migration and the Rise of the United States: The Role of Old and New Diasporas. Edinburgh University Press 2024.</strong></li>
          <li><strong>Brain Rejection under the Trump Presidency: Evidence from Indian and Mexican Professionals in the U.S., (Co-authored), pp. 155-182 in Mónica Verea (Ed.) Anti-Immigrant Rhetoric, Actions, And Policies During The Trump Era (2017-
2019), ISBN 978-607-30-3563-7. UNAM, Mexico, 2020. 
</strong></li>
          <li><strong>Indian Diaspora as an Instrument of India’s Soft Power in Yashush Watanabe (Ed.), Handbook of Cultural Security (UK: Edward Elgar Publishing, 2018). (Co-authored with Prof. Sanjay Pandey). ISBN 987-1-78643-773-0. Citation-7 </strong></li>
          <li><strong>Coups, Constitutions and the Struggle for Power: Contours of Racial Politics in Fiji, in Manmohini Kaul & Anushree Chakraborty (Eds.) India's Look East to Act East Policy: Tracking the Opportunities and Challenges in the Indo-Pacific (New Delhi: Pentagon Press, 2016). ISBN 9788182748477. Citations-1</strong></li>
          <li><strong>Patterns of Migration and the Formation of the Indian Diaspora in Colonial India, in Sutapa Dutta and Nilanjana Mukherjee (Eds.) Mapping India: Transitions and Transformations, 18th to 19th Century (New Delhi; Routledge). 2019. ISBN 9780429318467. Citations- 4 </strong></li>
          <li><strong>Diaspora and Development: Theoretical Perspectives in Irudaya Rajan (Ed.), India Migration Report, 2014, Routledge.
</strong></li>
          <li><strong>Indian Student Migration: Critical Analysis, in Irudaya Rajan (Ed.) Youth Migration in Emerging India: Young People and Migration, Orient Black Swan, 2018. </strong></li>
          <li><strong>Movement of Service Providers: Opportunities and Challenges for India in Rupa Chanda (Ed), Trade in Services in India: Prospects and Strategies, with a Foreword by Prof. Jagdish Bhagwati (co-authored), CENTAD (Wiley-India, 2006), ISBN 81-265- 1081-1.</strong></li>
          <li><strong>Role of the Indian Diaspora in India-Netherlands Relations, IDPAD (Indo-Dutch Programme on Alternative Development) Newsletter, Vol. 3, No. 1, January-June 2005.</strong></li>
          <li><strong>Diaspora: Identities, Spaces and Practices in Nandini Sen (Ed.) Through the Diasporic Lens, Delhi; Authors Press, 2017, pp. 27-37 ISBN 978-99-5207-524-9. Citations: 4</strong></li>
          <li><strong>India’s Engagement with the Girmit Diaspora: Prejudices and Prospects, in Maurits S Hassankhan, Rachel Kurian, Lomarsh Roopnarine, and Ashutosh Kumar (Eds.) Historical and Contemporary Aspects of Indian Indenture and Migration (New Delhi: The Manohar), 2025.</strong></li>
          <li><strong>Indo-Fijians and Their Success Story in Fiji in Ajay Dubey (Ed) Indian Diaspora Contributions to Their New Home, 2011, New Delhi; MD Publications</strong></li>
          <li><strong>Australia’s Policy Towards the South Pacific with Special Reference to PNG and Fiji in
D. Gopal (Ed), Australia in the Emerging World Order (Delhi: Shipra Publications, 2002)
</strong></li>
<li><strong>Unpacking Indian Diaspora in Samuel Asir Raj & M. Nadarajah (Eds.) Absences, Silences and the Margin: A Mosaic of Voices on the Indian and Tamil Diaspora by CDS, MS University, TN, India, 2018</strong></li>
        </ul>
      </details>
    </br></br>
  <h2>Commentaries & Newspaper Articles</h2>
    <details>
        <summary>(Click) View Commentaries</summary>
        <ul>
          <li>
            Bose beyond the Mystery, Strategic Analysis, 40:4, 234-238 
          </li>
          <li>
            Airlift' and a reflection on India's Diaspora Policy
          </li>
          <li>
            India and Pacific Islands Region: Building New Partnerships

          </li>
          <li>
            Exile and After, Hindustan Times, 18/8/2000 
          </li>
          <li>
            Extending the Idea of India, The Indian Express, 27/8/2006
          </li>
          <li>Getting Out of Debt Trap in the Gulf, The Pioneer, 23/7/2014</li>
           <li>Reaping the Diaspora Dividend, Financial Express, 21/11/2014</li>
           <li>Bose, His Files, and Rewriting His History, Millennium Post, 21/9/2015</li>
        </ul>
      </details>
      </section>
      <section id="pdf-library" class="section">
  <h2> PDFs</h2>

  <?php if (!isset($_SESSION['user_id'])): ?>
    <p style="font-size:14px; opacity:0.7;">
      Please <a href="login.php">login</a> to access research papers.
    </p>
  <?php else: ?>

    <ul class="styled-list">
      <?php if (empty($pdfs)): ?>
        <li style="opacity:0.6; font-style:italic;">
          PDFs will be available soon.
        </li>
      <?php else: ?>
        <?php foreach ($pdfs as $pdf): ?>
          <li>
            <?= htmlspecialchars($pdf['title']) ?> —
            <a href="pdf.php?id=<?= $pdf['id'] ?>"
               class="links_edit"
               target="_blank">
              View PDF
            </a>
          </li>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>

  <?php endif; ?>
</section>
      <section id="conferences" class="section">
  <h2>Conferences & Event Organizations</h2>

  <?php
  $conferences = $pdo->prepare(
    "SELECT title, year FROM achievements
     WHERE type='conference'
     ORDER BY year DESC, created_at DESC"
  );
  $conferences->execute();
  ?>

  <?php foreach ($conferences as $c): ?>
    <div class="achievement-item">
      <h4>
        <?= htmlspecialchars($c['title']) ?>
        <?php if (!empty($c['year'])): ?>
          (<?= htmlspecialchars($c['year']) ?>)
        <?php endif; ?>
      </h4>
    </div>
  <?php endforeach; ?>

</section>
      <section id="conferences" class="section">
  <h2>Independent Invited Lectures & Presentations</h2>
  
    <div class="achievement-item">
      <h4>Invited to speak as a plenary speaker on India and the EU’s Common Agenda on Migration and Mobility, and Female Migration: A Critical Analysis, in the 5th national conference on rethinking international migration & mobility narratives and frameworks, organised by IIMAD and ICWA, 17-18 November 2025, at Trivandrum, Kerala.
      </h4>
    </div>
    <div class="achievement-item">
      <h4>Invited to speak as a plenary speaker on Indians in Myanmar: Past and Present at the International Conference on Indian Engagement with Its Diaspora at BHU, Varanasi, 8-10 December, 2025
      </h4>
    </div>
    <div class="achievement-item">
      <h4>Invited to give a public lecture at the National Archives in Suriname, titled 'Working with the Diaspora for Development: Best Practices and Lessons for Suriname?' on 27 March 2024.
      </h4>
    </div>
    <div class="achievement-item">
      <h4>Participated (by invitation) in the Second Asia-Pacific Regional Review of Implementation of the Global Compact for Safe, Orderly, and Regular Migration (GCM), which UNNM, IOM, and ESCAP organised at UNCC in Bangkok.
      </h4>
    </div>
    <div class="achievement-item">
      <h4>Delivered a Valedictory address titled ‘Indian Diaspora: Transitioning from Soft Power to Smart Power for India’, in a conference, Indian Diaspora: Paving the Path of Viksit Bharat by 2047, organised by the Centre for International Trade & Development, School of International Studies, on February 13, 2025. 
      </h4>
    </div>
    <div class="achievement-item">
      <h4>Delivered keynote speech ‘Diasporas as Transnational Communities: Concepts and Practices’ at a one-day national seminar on ‘Migration and Diaspora: Prospects and Encounters’ on 17 September 2022 at Guru Nanak Khalsa College of Arts, Science & Commerce (Autonomous), Matunga (East), Mumbai.
      </h4>
    </div>
    <div class="achievement-item">
      <h4>Delivered a keynote speech at the webinar on ‘Women in Indian Diaspora: Changing Discourses’ held on 28 September 2021, organised by Gathari Girmitiya and Antar Rashtriya Sahyog Parishad.
      </h4>
    </div>
    <div class="achievement-item">
      <h4>I delivered a one-hour independent presentation titled “Indian Folk Tradition in Indentured Societies” at ARSD College, New Delhi, on October 30, 2023.
      </h4>
    </div>
    <div class="achievement-item">
      <h4>Delivered a one-hour independent presentation on Gender Issues in the Indian Diaspora at a short-term course organised by Khalsa College on 16 April 2025.
      </h4>
    </div>
    <div class="achievement-item">
      <h4>Delivered a one-hour independent presentation on Gender Issues in the Indian Diaspora at a short-term course organised by Khalsa College in February 2022.
      </h4>
    </div>
    <div class="achievement-item">
      <h4>Spoke about the Girmit Diaspora as a soft power for India as a plenary speaker at The Saga of Girmitiya Migration: Re-engaging the Homeland, Culture, History and Memory (27-29 April 2022). 
      </h4>
    </div>
    <div class="achievement-item">
      <h4>Spoke as a plenary speaker on Indian Diaspora as a factor in India-Myanmar relations at the International Interdisciplinary Series of Conferences on The Global Indian Diasporas, CDS CUG Gujarat, 23-25 February 2023.
      </h4>
    </div>
    <div class="achievement-item">
      <h4>Gave an hour-long independent presentation titled "Engendering Migration During the COVID Crisis" at a webinar organised by ARSD College, University of Delhi, on 15 May 2020.
      </h4>
    </div>
    <div class="achievement-item">
      <h4>Delivered a one-and-a-half-hour presentation on The Role of Diasporas /Migration in the Development of National High-tech Industries: The case of India’s IT industry and the US-based highly skilled Indian diaspora as an Eminent Lecturer at the São Paulo School of Advanced Science on Science Diplomacy and Innovation Diplomacy (InnSciD SP), 21-30 August 2019.
      </h4>
    </div>
    <div class="achievement-item">
      <h4>Delivered the keynote address, 'Unpacking Indian Diaspora,' at the International Conference on Absences, Silences and Margins: Restructuring Indian Diaspora Studies, 7-9 January 2016, Kanyakumari, Tamil Nadu, India.
      </h4></div>
      <div class="achievement-item">
      <h4>An hour-long presentation on Diaspora and Development: The Indian Experience, Department of Business Economics, University of South Pacific, Suva, Fiji 2011.
      </h4></div>
      <div class="achievement-item">
      <h4>An hour-long presentation titled "Indo-Fijians: A Quest for Identity" took place on 21 June 2011 at the Department of Anthropology and Archaeology, University of Otago, Dunedin, NZ.
      </h4></div>
      <div class="achievement-item">
      <h4>An hour-long lecture on Nuclear-Weapon-Free Zones and India’s Strategic Interests in Southeast Asia and the South Pacific, 22 June 2011, at the National Centre for Peace and Conflict Studies, University of Otago, Dunedin, NZ.
      </h4></div>
      <div class="achievement-item">
      <h4>Delivered a lecture on the migration of girls and women from smaller towns to Delhi, addressing issues related to stress management for the residents of the Girls' Hall, Jamia Millia Islamia, on 9 September 2008.
      </h4></div>
      <div class="achievement-item">
      <h4>Gave a presentation on India and its Diaspora in Southeast Asia at the Institute of Studies in Industrial Development, New Delhi, on 8 March 2011.
      </h4>
    </div>
</section>
<section id="books" class="section">
      <h2>Papers Presented in Conferences</h2>

      <details>
        <summary>(Click) View Papers Presented at International Conferences</summary>
        <ul>
          <li>
            <strong>Presented a paper titled "Global Indian Diaspora: From Soft Power to Smart Power for India" at the two-day international conference "Changing Dynamics of Migration and Indian Diaspora: Leveraging India’s Global Image," organised by the Centre for West Asian Studies, Jamia Millia Islamia, New Delhi, on 18-19 November 2024. </strong>
          </li>
          <li>
            <strong>Presented a paper titled' Role of Indian Diaspora, INA in India’s Independence' at the International Conference' The Role of Indian Diaspora in India's Freedom Struggle' on 31 March and 01 April 2024, in Kuala Lumpur, Malaysia.</strong>
          </li>
          <li>
            <strong>Presented a paper on Women and Indenture at an international conference on Indian Diaspora Women and Patriarchy: Questions on Inclusion, Cultural Identity, and Violence, organised by the Centre for the Study of Social Exclusion & Inclusive Policy (CSSEIP), University of Hyderabad, 4th–5th December 2023.
</strong>
          </li>
          <li>
            <strong>Presented paper titled 'Girmit Diaspora as India’s Soft Power or Smart Power?' at the International Conference on Celebrating Girmitiya Lives, held from 12 to 13 May 2023 in Fiji at the University of the South Pacific. </strong>
          </li>
          <li>
            <strong>Presented paper titled 'Girmit Diaspora as Instrument of India`s Soft Power' at the International Conference 'Contemporary Indian Diaspora: A Global Perspective', School of Mauritian & Area Studies, 17-18 August 2022.</strong>
          </li>
          <li><strong>Presented a paper in a panel discussion on ‘Students’ Mobility: Challenges, Opportunities and Prospects ’held on the 15th of January 2020 at Pravasi Bhartiya Kendra, New Delhi.</strong></li>
          <li><strong>Presented a paper titled "Diaspora as a Factor in India’s Soft Power Strategy" at the International Conference "Kala Pani Crossings #1: India in Conversation," organised by IIAS, Shimla, from 23 to 25 September 2019.</strong></li>
          <li><strong>Presented a paper titled 'Women and Indenture: Revisiting Indian Discourses' at the International Conference 'Kala Pani Crossings #2: Diaspora and Gender across the Indian and Atlantic Oceans', held on 26-27 February 2020 at Pondicherry University.</strong></li>
          <li><strong>Presented a paper on Holi in Delhi at the First International Fagwa conference organised by Trinidad Cultural Centre on March 13-14, 2021.</strong></li>
          <li><strong>Presented a paper titled Diaspora as a Factor in India’s Soft Power Strategy at the International conference Kala Pani Crossings #1: India in Conversation, organised by IIAS, Shimla, Sept 23-25, 2019.</strong></li>
          <li><strong>Presented a paper titled 'Transnational Belonging through Virtual Spaces: Impact of Digital Media on Diasporic Identities' at the International Seminar 'Mapping Indian Diaspora: Issues and Perspectives' organised by SIES Mumbai on 13-14 December 2019.</strong></li>
          <li><strong>Presented a paper titled India and its Diaspora in West Asia: Nature, Significance, and Belonging in International Conference India’s Emerging Relations with West Asian Countries: A Global Perspective” to be held on 27-28 January 2020 at Jamia Millia Islamia, New Delhi.</strong></li>
          <li><strong>13.	Presented a paper titled The Corona Pandemic, livelihood Challenges and Reverse Migration: A Gendered Perspective in a Webinar Corona Pandemic, Dislocation, and Livelihood Challenges: Multilevel Perspectives on Concerns and Coping Strategies, organised by Government College, Sikar, Rajasthan.</strong></li>
          <li><strong>Presented a paper titled The Corona Pandemic and Livelihood Challenges: Addressing the Impacts on the Migrant Women, in the Webinar Women and Gender Discourse, organised by BHU, June 27, 2020</strong></li>
          <li><strong>Presented paper in co-authorship titled Brain Rejection Under the Trump Presidency: Evidence from Indian and Mexican Professionals in the US, in the international seminar “Trump: Anti-immigrant Rhetoric, actions and Policies 2017-2019” Ciudad Universitario, Mexico City on February 13, 14th, 2019.</strong></li>
          <li><strong>Presented a paper titled "The Rise and Growth of Indians as a Political Force in Mauritius and Fiji: A Comparative Overview" at the International Conference on Diaspora and Nation Building, held on 5-6 July 2018 in Mauritius, organised by ARSP</strong></li>
          <li><strong>Presented a paper titled India’s Engagement with the Girmit Diaspora: Prejudices and Prospects in the International Conference Legacy of Slavery and Indentured Labour, 18-23 June 2018, Paramaribo, Suriname.</strong></li>
          <li><strong>Presented a paper Conference Indian Diaspora in South East Asia with a Special Focus on Vietnam, organised by the Centre for Indo-Pacific Studies, SIS, in Partnership with ONGC Videsh Ltd., and the Embassy of the Socialist Republic of Vietnam, 14-23 January 2019</strong></li>
          <li><strong>Presented a paper on India’s Act East Policy and ASEAN in Ascending India: Reflections on Global and Regional Dimensions, Annual International and Area Studies Convention, 30 Jan-1 Feb 2019</strong></li>
          <li><strong>Presented a paper UGC-Human Resource Development Centre, Jamia Millia Islamia, New Delhi, Diaspora, and Nation Building: Emerging Trends, Opportunities and Challenges, 7-8 March 2018.</strong></li>
          <li><strong>Presented a paper titled Colonial Migrations and the Formation of Indian Diaspora in a two-day Annual Conference Mapping India in the Eighteenth Century: Transformations and Transitions, 6-7 March 2017, organised by India International Society for Eighteenth-Century Studies (IISECS).</strong></li>
          <li><strong>Presented paper titled Skilled Immigration and Conditions of Labour Competition in the US: A Comparative Study of Indian, Mexican and Chinese Diasporas, in an International Conference, Migration and Diasporas, Emerging Diversities and Development Challenges, 22-23 March 2017, organised by the School of Interdisciplinary and Trans-disciplinary Studies, Indira Gandhi National Open University, New Delhi.</strong></li>
          <li><strong>Made in absentia virtual presentation titled India’s Engagement with Girmit Diaspora: Prejudices and Prospects at International Conference on Commemoration of Centennial of Abolition of Indenture, 22-24 March 2017 in Fiji</strong></li>
          <li><strong>Presented paper titled "India’s Experience with Remittances: Past and Present" at the International Conference to Commemorate the Centenary of the Abolition of the Indenture System, held in New Delhi, organised by Anter Rashtriya Sahyog Parishad, on 20-21 April 2017.</strong></li>
          <li><strong>Presented paper titled 'Diaspora and Development: India’s Experience with Remittances' at the International Conference on Diaspora and International Migration.
Development: Comparative Global Experiences, 10-11 January 2016, JNU, New Delhi, India
</strong></li>
          <li><strong>Presented paper titled 'Role of Indians in the Establishment of Democracy in Fiji: A Historical Perspective' at the conference 'Indian Diaspora in Development of Home and Host Countries: A Comparative Perspective'. Venue: Kadi University, Gandhinagar, Gujarat, 10th-11th January 2015. Organised by the Organisation of Diaspora Initiative, Centre for African Studies, SIS, JNU. Location: Ahmedabad, Gujarat.</strong></li>
          <li><strong>Presented paper titled The New Constitution and Recent Elections in Fiji: A Critical Analysis at Annual International Studies Convection Power Resistance and Justice in the International System: Perspectives from the South, School of International Studies, JNU, 22-23, March 2015</strong></li>
          <li><strong>Delivered a virtual presentation titled “India and the Pacific Islands Region: Building New Partnerships” at the International Conference on Leadership and Governance, 31 October 2015, Palm Beach, Florida.</strong></li>
          <li><strong>Presented paper titled 'Role of Diasporas in Homeland Conflicts and Reconstruction: The Case of Tamil Diaspora and Sri Lanka' at the Sri Lankan on the Move: An International Conference on Migration (ICSOM), Colombo, Sri Lanka, 23–25 January 2013, at The Kingsbury (formerly Ceylon Continental Hotel), Colombo, Sri Lanka.</strong></li>
          <li><strong>Presented paper 'Role of Diaspora in the Development of Indian IT Industry” at an International Conference on India and its Diaspora: A Comparative Perspective, organised by the Organisation of Diaspora Initiatives, Centre for African Studies, SIS, JNU, and India International Centre, New Delhi, on the 29th and 30th of March 2013.</strong></li>
          <li><strong>Presented paper 'Role of Diasporas in Homeland Conflicts/Conflict Resolution and Post-War Reconstruction: The Case of Tamil Diaspora and Sri Lanka” at India's Foreign Policy and National Security: A Comparative Perspective, 6–7 November 2013, at India International Centre, New Delhi, organised by the Organisation for Diaspora Initiatives (ODI), Centre for African Studies, SIS, JNU, and India International Centre (IIC).</strong></li>
          <li><strong>Presented paper titled 'The Fiji Gujaratis' at the International Conference celebrating the 50th anniversary of Swarnim Gujarat: Role of Gujarati Diaspora, from 2-4 January 2011, Patan, Gujarat.</strong></li>
          <li><strong>Presented a paper titled “India and its Diaspora in Fiji” at an international conference on Indian Diaspora Policy: Regional and Linguistic Challenges on October 12, 2011. The event was organised by the Organisation for Diaspora Initiatives (ODI) and the Centre for African Studies, SIS, JNU, at the India International Centre (IIC).</strong></li>
          <li><strong>Presented a paper titled "Indians and the Power Struggle in Fiji" at the International Seminar on India and the Indian Diaspora on 29 and 30 March 2004, organised by the Organisation for Diaspora Initiatives (ODI) and the Centre for African Studies, SIS, JNU.</strong></li>
          
        </ul>
      </details>
      <details>
        <summary>(Click) View Papers Presented at National Conferences</summary>
        <ul>
          <li>
            <strong>Presented a paper, Diaspora Identities, in a National Seminar titled Scenario of Indian Culture in diaspora literature: In the Context of Past and Present, Jointly Organised by Research Forum and Adikabi Sarala Das Chair of Odia Studies, JNU, New Delhi, SIS, JNU, 09-10 January 2019</strong>
          </li>
          <li>
            <strong>Presented a paper titled 'Role of Diasporas in Homeland Conflicts, Conflict Resolution and Post-War Reconstruction: The Case of Sri Lankan Tamil Diaspora' at the Academic Staff College, JNU, from 24 to 28 March 2014. </strong>
          </li>
          <li>
            <strong>Presented a paper titled 'Indian Diaspora and Foreign Policy' at a national seminar titled 'Culture and Identity in International Relations: Impact on Foreign Policy', organised by the School of International Studies, JNU, from 16 to 17 March 2006. 
</strong>
          </li>
          <li>
            <strong>Presented a paper titled 'Australia’s Policy towards the South Pacific with Special Reference to PNG and Fiji' at a national conference, 'Australia in a Changing World,' organised by IGNOU in February 2002. </strong>
          </li>
          <li>
            <strong>Presented a paper on the State of Documentation in Southeast Asian Studies at a seminar on the State of Asian Studies in India held on 19-20 March 1998, organised by ICSSR, New Delhi.</strong>
          </li>
          <li><strong>Presented a paper, Managing Bangladeshi Immigration into India: Options and Challenges, at the Faculty Seminar on South Asia: Internal Dynamics and External Linkages, SIS, JNU, 23-14 January 2012. </strong></li>
        </ul>
      </details>
    </section>

    <section id="conferences" class="section">
  <h2>Review of Articles and Editorial Positions</h2>
    <section>
        <ul>
          <li>
           I have regularly reviewed papers for journals in my field, such as *International Studies* (Sage), *Diaspora Studies* (Taylor and Francis), *Migration and Development* (Taylor and Francis), *Globalisations* (Taylor and Francis), *South Asian Diaspora* (Taylor and Francis), and several edited volumes with Springer and Routledge. 
          </li>
          <li>
            Part of the advisory board of the Edinburgh Studies on Diasporas and Transnationalism
          </li>
          <li>
            Founder and co-editor of Migration and Diaspora: An Interdisciplinary Journal. GRFDT, New Delhi (http://www.grfdt.com)
          </li>
          <li>
           Member of the Editorial Board as a book review editor of the Diaspora Studies journal (Routledge), 2014- 2018. 
          </li>
          <li>
            Associate editor with International Studies Journal (Sage) 2019-2022.
          </li>
          <li>Member of the editorial board of Social Sciences</li>
           <li>Reaping the Diaspora Dividend, Financial Express, 21/11/2014</li>
           <li>Bose, His Files, and Rewriting His History, Millennium Post, 21/9/2015</li>
        </ul>
      </section>
      </section>
     <!-- ================= PDF LIBRARY ================= -->

    <!-- ================= GALLERY ================= -->
    <section id="gallery" class="section">
  <h2 class="section-title">Gallery</h2>

  <?php foreach ($events as $event): ?>
    <div class="gallery-event">

      <h3 class="gallery-title">
        <?= htmlspecialchars($event['title']) ?>
        <span class="gallery-year">
          (<?= htmlspecialchars($event['year']) ?>)
        </span>
      </h3>

      <div class="gallery-grid">

        <?php
        $imgs = $pdo->prepare(
          "SELECT filename FROM gallery_images WHERE event_id = ?"
        );
        $imgs->execute([$event['id']]);

        foreach ($imgs as $img):
        ?>

          <img 
            src="/uploads/gallery/<?= htmlspecialchars($img['filename']) ?>"
            alt="Gallery Image">

        <?php endforeach; ?>

      </div>
    </div>
  <?php endforeach; ?>

</section>

    <!-- ================= FOOTER ================= -->
    <footer id="contact">
      <div>
        <strong>Email</strong><br />
        ambapande@gmail.com
      </div>

      <div>
        <strong>Affiliation</strong><br />
        Jawaharlal Nehru University, New Delhi
      </div>

       <div style="padding-top:5px;">
        <strong>© 2026 Dr. Amba Pande. All rights reserved.</strong>
      </div>

    </footer>
  </body>
</html>
