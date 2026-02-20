document.addEventListener("DOMContentLoaded", function () {
  console.log("JS loaded");
  document.querySelectorAll(".desk-card").forEach(card => {
    card.addEventListener("click", function () {

      const title = this.dataset.title;
      const date = this.dataset.date;
      const content = this.dataset.content;

      openBlog(title, date, content);
    });
  });

  /* =========================
   MOBILE NAVBAR (FIXED)
========================= */
  const menuToggle = document.getElementById("menuToggle");
  const navMenu = document.getElementById("navMenu");

  if (menuToggle && navMenu) {
    menuToggle.addEventListener("click", () => {
      const isOpen = navMenu.classList.toggle("active");
      menuToggle.setAttribute("aria-expanded", isOpen);
    });

    // Close menu when clicking a link
    navMenu.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", () => {
        navMenu.classList.remove("active");
        menuToggle.setAttribute("aria-expanded", "false");
      });
    });
  }
  /* =========================
     REGISTER PAGE 
  ========================== */
  function getCookie(name) {
    let cookieValue = null;

    if (document.cookie && document.cookie !== "") {
      const cookies = document.cookie.split(";");

      for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();

        if (cookie.substring(0, name.length + 1) === name + "=") {
          cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
          break;
        }
      }
    }

    return cookieValue;
  }

  /* =========================
     AUTH – REGISTER (OTP)
  ========================== */
  const sendOtpBtn = document.getElementById("sendOtpBtn");
  const registerBtn = document.getElementById("registerBtn");
  const otpSection = document.getElementById("otpSection");

  if (sendOtpBtn) {
    sendOtpBtn.addEventListener("click", () => {
      const email = document.getElementById("email")?.value.trim();
      if (!email) return alert("Please enter your email");

      const data = new FormData();
      data.append("email", email);

      fetch("ajax/send_otp.php", {
        method: "POST",
        body: data,
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.status === "otp_sent") {
            alert("OTP sent to your email");
            otpSection.style.display = "block";
          } else if (res.status === "already_registered") {
            alert("Already registered. Please login.");
            window.location.href = "login.php";
          } else {
            alert("Failed to send OTP");
          }
        });
    });
  }

  if (registerBtn) {
    registerBtn.addEventListener("click", () => {
      const name = document.getElementById("name")?.value.trim();
      const email = document.getElementById("email")?.value.trim();
      const otp = document.getElementById("otp")?.value.trim();

      if (!name || !email || !otp) return alert("Fill all fields");

      const data = new FormData();
      data.append("name", name);
      data.append("email", email);
      data.append("otp", otp);

      fetch("ajax/verify_register.php", {
        method: "POST",
        body: data,
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.status === "verified") {
            alert("Registration successful");
            window.location.href = "login.php";
          } else {
            alert("Invalid OTP");
          }
        });
    });
  }


  /* =========================
   AUTH – LOGIN
========================= */
const loginBtn = document.getElementById("loginBtn");

if (loginBtn) {
  loginBtn.addEventListener("click", () => {
    const name = document.getElementById("name")?.value.trim();
    const email = document.getElementById("email")?.value.trim();

    if (!name || !email) {
      alert("Fill all fields");
      return;
    }

    const data = new FormData();
    data.append("name", name);
    data.append("email", email);

    fetch("ajax/login.php", {
      method: "POST",
      body: data
    })
      .then(res => res.json())
      .then(res => {
        if (res.status === "logged_in") {
          window.location.href = "index.php";
        } else {
          alert("Login failed. Check name or email.");
        }
      })
      .catch(() => alert("Server error"));
  });
}
});

/* =========================
   BLOG PANEL (GLOBAL)
========================= */
function openBlog(title, date, content) {
  document.getElementById("panelTitle").innerText = title;
  document.getElementById("panelDate").innerText = date;
  document.getElementById("panelContent").innerHTML = content;

  document.getElementById("blogOverlay").style.display = "flex";
  document.body.style.overflow = "hidden";
}


function closeBlog() {
  document.getElementById("blogOverlay").addEventListener("click", function(e){
  if(e.target === this) closeBlog();
    });
  document.getElementById("blogOverlay").style.display = "none";
  document.body.style.overflow = "auto";
}
