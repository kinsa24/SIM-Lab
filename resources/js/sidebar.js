let sidebarOpen = true;

window.toggleSidebar = function () {
    document.getElementById('sidebar').classList.toggle('collapsed', sidebarOpen);
    document.getElementById('main').classList.toggle('expanded', sidebarOpen);
    sidebarOpen = !sidebarOpen;
};

window.toggleGroup = function () {
    document.getElementById('masterHeader').classList.toggle('open');
    document.getElementById('masterMenu').classList.toggle('open');
};
