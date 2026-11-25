            </div><!-- end main-inner -->
        </main>
    </div><!-- end shell -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            var side = document.getElementById('side');
            var scrim = document.getElementById('scrim');
            var tombol = document.getElementById('sideToggle');
            if (!side || !tombol) return;
            function atur(buka) {
                side.classList.toggle('is-open', buka);
                scrim.classList.toggle('is-open', buka);
                tombol.setAttribute('aria-expanded', buka ? 'true' : 'false');
            }
            tombol.addEventListener('click', function () { atur(!side.classList.contains('is-open')); });
            scrim.addEventListener('click', function () { atur(false); });
        })();
    </script>
</body>
</html>
