var admin_theme_selected = localStorage.getItem("admin_theme");
if (admin_theme_selected == 1) {
  $(".navbar-menu-wrapper .header-right").removeClass('admin_top_bar_color');
  $(".navbar .navbar-menu-wrapper").removeClass('admin_top_bar_color');
  $(".navbar .navbar-brand-wrapper").removeClass('admin_logo_color');
  $(".body-common-class").removeClass('admin_side_bar_color');
  $(".sidebar-offcanvas").removeClass('admin_side_bar_color');
  $(".sidebar-offcanvas .navbar-nav").removeClass('admin_side_bar_color');
  $(".dashboard-wrap").removeClass('admin_side_bar_color');
  $(".dashboard-wrap").css('background-color', '#3a3f51');
  $(".body-common-class").css('background-color', '#3a3f51');
  $(".footer-bg .dashboard-footer").removeClass('admin_footer_color');

  $('.admin_theme_selected').removeClass('fa fa-toggle-off');
  $('.admin_theme_icon').removeClass('fas fa-sun');
  $('.admin_theme_selected').addClass('fa fa-toggle-on');
  $('.admin_theme_icon').addClass('fas fa-moon');
}else{
  $(".dashboard-wrap").css('background-color', '');
  $(".body-common-class").css('background-color', '');
  $(".navbar-menu-wrapper .header-right").addClass('admin_top_bar_color');
  $(".navbar .navbar-menu-wrapper").addClass('admin_top_bar_color');
  $(".navbar .navbar-brand-wrapper").addClass('admin_logo_color');
  $(".body-common-class").addClass('admin_side_bar_color');
  $(".sidebar-offcanvas").addClass('admin_side_bar_color');
  $(".sidebar-offcanvas .navbar-nav").addClass('admin_side_bar_color');
  $(".dashboard-wrap").addClass('admin_side_bar_color');
  $(".footer-bg .dashboard-footer").addClass('admin_footer_color');

  $('.admin_theme_selected').removeClass('fa fa-toggle-on');
  $('.admin_theme_icon').removeClass('fas fa-moon');
  $('.admin_theme_selected').addClass('fa fa-toggle-off');
  $('.admin_theme_icon').addClass('fas fa-sun');
}

function change_admin_theme() {
  $('#admin_theme_action').toggleClass('fa-toggle-off');
  $('#admin_theme_action').toggleClass('fa-toggle-on');

  var isDark  = $("#admin_theme").val();
  var sidebar_classes = "sidebar-light sidebar-dark";
  var $body = $("body")

  $("#admin_theme").val(isDark == 0 ? 1 : 0);
  $("#theme-settings").toggleClass("open");
  $body.toggleClass(sidebar_classes);
  $body.toggleClass("sidebar-light");
  $(".sidebar-bg-options").removeClass("selected");
  localStorage.removeItem('admin_theme');
  localStorage.setItem('admin_theme',isDark == 0 ? 1 : 0);

  if ($('.admin_theme_selected').hasClass('fa fa-toggle-off')) {
    $(".navbar-menu-wrapper .header-right").removeClass('admin_top_bar_color');
    $(".navbar .navbar-menu-wrapper").removeClass('admin_top_bar_color');
    $(".navbar .navbar-brand-wrapper").removeClass('admin_logo_color');
    $(".body-common-class").removeClass('admin_side_bar_color');
    $(".sidebar-offcanvas").removeClass('admin_side_bar_color');
    $(".sidebar-offcanvas .navbar-nav").removeClass('admin_side_bar_color');
    $(".dashboard-wrap").removeClass('admin_side_bar_color');
    $(".dashboard-wrap").css('background-color', '#3a3f51');
    $(".body-common-class").css('background-color', '#3a3f51');
    $(".footer-bg .dashboard-footer").removeClass('admin_footer_color');

    $('.admin_theme_selected').removeClass('fa fa-toggle-off');
    $('.admin_theme_icon').removeClass('fas fa-sun');
    $('.admin_theme_selected').addClass('fa fa-toggle-on');
    $('.admin_theme_icon').addClass('fas fa-moon');
  }else{
    $(".dashboard-wrap").css('background-color', '');
    $(".body-common-class").css('background-color', '');
    $(".navbar-menu-wrapper .header-right").addClass('admin_top_bar_color');
    $(".navbar .navbar-menu-wrapper").addClass('admin_top_bar_color');
    $(".navbar .navbar-brand-wrapper").addClass('admin_logo_color');
    $(".body-common-class").addClass('admin_side_bar_color');
    $(".sidebar-offcanvas").addClass('admin_side_bar_color');
    $(".sidebar-offcanvas .navbar-nav").addClass('admin_side_bar_color');
    $(".dashboard-wrap").addClass('admin_side_bar_color');
    $(".footer-bg .dashboard-footer").addClass('admin_footer_color');

    $('.admin_theme_selected').removeClass('fa fa-toggle-on');
    $('.admin_theme_icon').removeClass('fas fa-moon');
    $('.admin_theme_selected').addClass('fa fa-toggle-off');
    $('.admin_theme_icon').addClass('fas fa-sun');
  }
}