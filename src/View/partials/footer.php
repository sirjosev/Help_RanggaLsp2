<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- Kolom 1: Alamat (Location) -->
            <div class="col-lg-6 footer-col">
                <h4 class="text-uppercase mb-4">Location</h4>
                <p class="lead mb-0">
                    Alamanda Tower Lantai 2 Unit-H1 Jl. TB. Simatupang No. 23 - 24 RT 001 RW 001,
                    Kelurahan Cilandak Barat, Kecamatan Cilandak, Jakarta Selatan, DKI Jakarta
                    <br />
                    Kode Pos 1243
                </p>
                <div class="map-responsive">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d966.3195365153447!2d106.80471588299955!3d-6.2909179536907365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f1f275c8afc3%3A0x7a3084e60947f99a!2sAlamanda%20Tower%2C%20Building%20Management.!5e0!3m2!1sid!2sid!4v1744843896947!5m2!1sid!2sid"
                        width="100%" height="250" style="border:0; border-radius: 0.5rem;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <!-- Kolom 2: Kontak (Contact Us) -->
            <div class="col-lg-6 footer-col">
                <h4 class="text-uppercase mb-4">Contact Us</h4>
                <p class="lead mb-1">
                    <i class="fas fa-envelope me-2"></i>
                    Email: <a href="mailto:admin@lspdks.co.id">admin@lspdks.co.id</a>
                </p>
                <p class="lead mb-0">
                    <i class="fas fa-phone me-2"></i>
                    Phone: <a href="tel:+6281188809565">081188809565</a>
                </p>
            </div>
        </div>

    </div>
    <div class="copyright py-4 text-center text-white">
        <div class="container">
            <small>Copyright &copy; LSP DIGITAL KREATIF SOLUSI 2023. All Rights Reserved</small>
        </div>
    </div>
</footer>

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
<!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
<!-- * *                               SB Forms JS                               * *-->
<!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
<!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
<script src="https.cdn.startbootstrap.com/sb-forms-latest.js"></script>

<!-- Custom Google Translate Widget -->
<style>
    /* Fixed Floating Widget */
    #lang-toggle-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        background: linear-gradient(45deg, #3498db, #2c3e50); /* Theme Gradient */
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        border: 2px solid #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: bold;
        font-family: 'Montserrat', sans-serif; /* Match headings */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }
    
    #lang-toggle-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.3);
    }

    /* Hide the default Google Translate Bar */
    .goog-te-banner-frame.skiptranslate {
        display: none !important;
    } 
    body {
        top: 0px !important; 
    }
    /* Hide the google translate element completely */
    #google_translate_element {
        display: none;
    }
</style>

<!-- Hidden Google Translate Element -->
<div id="google_translate_element"></div>

<!-- Custom Toggle Button -->
<div id="lang-toggle-btn" onclick="toggleLanguage()" title="Switch Language">
    <span id="lang-text">EN</span>
</div>

<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'id',
            includedLanguages: 'id,en',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false
        }, 'google_translate_element');
    }

    // Function to get cookie
    function getCookie(name) {
        // Search for the cookie by name
        var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        if (match) return match[2];
        return null; // Return null if not found
    }

    // Function to set cookie
    function setCookie(name, value, days) {
        var d = new Date;
        d.setTime(d.getTime() + 24*60*60*1000*days);
        document.cookie = name + "=" + value + ";path=/;domain=" + window.location.hostname;
    }

    // Initialize button state
    function initLangButton() {
        var lang = getCookie('googtrans');
        var text = document.getElementById('lang-text');
        
        // If cookie exists and ends with /en (so /id/en or /auto/en), we are in English
        // Button should show "ID" to switch back
        if (lang && lang.match(/\/en$/)) {
            text.innerText = "ID"; 
        } else {
            // Default or ID, show "EN" to switch to English
            text.innerText = "EN"; 
        }
    }

    function toggleLanguage() {
        var lang = getCookie('googtrans');
        if (lang && lang.match(/\/en$/)) {
            // Current is English, switch to Indonesian
            setCookie('googtrans', '/id/id', 0); // Clear or set to ID
            // Also explicitly clear for domain just in case
            document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=" + window.location.hostname;
            document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            location.reload();
        } else {
            // Current is ID (or null), switch to English
            setCookie('googtrans', '/id/en', 1);
            location.reload();
        }
    }

    // Run init on load
    window.addEventListener('load', initLangButton);
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>

</html>
