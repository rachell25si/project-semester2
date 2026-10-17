    </div><!-- /page-content -->
</div><!-- /main-content -->

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    sidebar.classList.toggle('open');
    overlay.style.display = sidebar.classList.contains('open') ? 'block' : 'none';
}

// Set topbar title from active sidebar link
document.addEventListener('DOMContentLoaded', function() {
    const active = document.querySelector('.sidebar-nav-link.active');
    if (active) {
        const label = active.querySelector('i').nextSibling?.textContent?.trim();
        if (label) document.getElementById('topbarTitle').textContent = label;
    }
});
</script>
</body>
</html>