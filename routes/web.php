<?php

use App\Http\Controllers\adminController\DashboardController as DashboardController;
use App\Http\Controllers\adminController\EventController;
use App\Http\Controllers\adminController\FaqController;
use App\Http\Controllers\adminController\GeneralSettingController;
use App\Http\Controllers\adminController\PagesController;
use App\Http\Controllers\adminController\AdminProfileController;
use App\Http\Controllers\adminController\AppointmentController;
use App\Http\Controllers\adminController\CategoryController;
use App\Http\Controllers\adminController\ContactAddress;
use App\Http\Controllers\adminController\homepageSliderController as homepageslider;
use App\Http\Controllers\Controller;
use App\Http\Controllers\adminController\couponController as couponController;
use App\Http\Controllers\adminController\EmailTemplateController;
use App\Http\Controllers\adminController\employeeController;
use App\Http\Controllers\adminController\NewsLetterController;
use App\Http\Controllers\adminController\NYCCalender;
use App\Http\Controllers\adminController\OrdersController;
use App\Http\Controllers\adminController\ProductController;
use App\Http\Controllers\adminController\ShirtController;
use App\Http\Controllers\adminController\UserInfoController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['check.loggedin'])->group(function () {
    Route::get('admin-login', [AdminProfileController::class, 'loginPage'])->name('admin');
    Route::post('admin-login-action', [AdminProfileController::class, 'loginAction'])->name('admin-login');
});

Route::get('logout', [AdminProfileController::class, 'logout'])->name('logout');

Route::middleware(['custom.auth'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    // Pages
    Route::get('pages', [PagesController::class, 'pages'])->name('pages');
    Route::get('add-page', [PagesController::class, 'addPage'])->name('add-page');
    Route::get('modify-page/{id}', [PagesController::class, 'modifyPage'])->name('modify-page');
    Route::post('change-page-status', [PagesController::class, 'changePageStatus'])->name('change-page-status');
    Route::post('delete-page', [PagesController::class, 'deletePage'])->name('delete-page');
    Route::post('page-action', [PagesController::class, 'pageAction'])->name('page-action');
    // General Settings
    Route::get('general-setting', [GeneralSettingController::class, 'generalSetting'])->name('generalSetting');
    Route::post('general-setting', [GeneralSettingController::class, 'generelSettingAction'])->name('general-setting');
    // Admin Profile
    Route::get('admin-profile', [AdminProfileController::class, 'adminProfile'])->name('profile');
    Route::post('account-update', [AdminProfileController::class, 'accountUpdate'])->name('account-update');
    // Faq Module
    Route::get('faq', [FaqController::class, 'adminFaq'])->name('faq-section');
    Route::post('delete-faq', [FaqController::class, 'deleteFaq'])->name('delete-faq');
    Route::get('add-new-faq', [FaqController::class, 'addFaq'])->name('add-faq');
    Route::post('add-new-faq-action', [FaqController::class, 'addNewFaq'])->name('add-new-faq');
    Route::get('modify-faq/{id}', [FaqController::class, 'modifyFaq'])->name('modify-faq');
    Route::post('modify-faq-action/{id}', [FaqController::class, 'modifyFaqAction'])->name('modify-faq-action');
    Route::post('change-faq-status', [FaqController::class, 'changeFaqStatus'])->name('changeFaqStatus');
    // Event Module
    Route::get('events', [EventController::class, 'events'])->name('events');
    Route::post('change-event-status', [EventController::class, 'changeEventStatus'])->name('change-event-status');
    Route::get('add-new-event', [EventController::class, 'addEvent'])->name('add-event');
    Route::get('edit-event/{id}', [EventController::class, 'editEvent'])->name('edit-event');
    Route::post('event-action', [EventController::class, 'eventAction'])->name('event-action');
    Route::post('delete-event', [EventController::class, 'deleteEvent'])->name('delete-event');
    // Homepage Slider Module
    Route::get('homepage-slider', [homepageslider::class, 'homepageSlider'])->name('homepage-slider');
    Route::post('change-slider-status', [homepageslider::class, 'changeSliderStatus'])->name('change-slider-status');
    Route::post('delete-homeslider', [homepageslider::class, 'deleteHomeSlider'])->name('delete-homeslider');
    Route::get('add-homeslider', [homepageslider::class, 'addHomeSlider'])->name('add-homeslider');
    Route::get('modify-homeslider/{id}', [homepageslider::class, 'modifyHomeslider'])->name('modify-homeslider');
    Route::post('homeslider-update', [homepageslider::class, 'homesliderUpdate'])->name('homeslider-update');
    // Discount Module
    Route::get('voucher', [couponController::class, 'discount'])->name('discount');
    Route::get('add-voucher', [couponController::class, 'addVoucher'])->name('add-coupon');
    Route::get('modify-voucher/{id}', [couponController::class, 'modifyVoucher'])->name('modify-coupon');
    Route::post('voucher-action', [couponController::class, 'voucherAction'])->name('voucher-action');
    Route::post('change-voucher-status', [couponController::class, 'changeVoucherStatus'])->name('change-voucher-status');
    Route::post('delete-voucher', [couponController::class, 'deleteVoucher'])->name('delete-voucher');
    // Emplpyee Module
    Route::get('employee', [employeeController::class, 'employee'])->name('employee');
    Route::get('add-employee', [employeeController::class, 'addEmployee'])->name('add-employee');
    Route::get('modify-employee/{id}', [employeeController::class, 'modifyEmpoyee'])->name('modify-employee');
    Route::post('change-employee-status', [employeeController::class, 'changeEmployeeStatus'])->name('change-employee-status');
    Route::post('delete-employee', [employeeController::class, 'deleteEmployee'])->name('delete-employee');
    Route::post('employee-action', [employeeController::class, 'employeeAction'])->name('employee-action');
    // category Module
    Route::get('category', [CategoryController::class, 'category'])->name('category');
    Route::get('add-category', [CategoryController::class, 'addCategory'])->name('add-category');
    Route::get('modify-category/{id}', [CategoryController::class, 'modifyCategory'])->name('modify-category');
    Route::post('delete-category', [CategoryController::class, 'deleteCategory'])->name('delete-category');
    Route::post('change-category-status', [CategoryController::class, 'changeCategoryStatus'])->name('change-category-status');
    Route::post('category-action', [CategoryController::class, 'categoryAction'])->name('category-action');
    // Product Module 
    Route::get('products', [ProductController::class, 'products'])->name('products');
    Route::get('add-product', [ProductController::class, 'addProduct'])->name('add-product');
    Route::get('modify-product/{id}', [ProductController::class, 'modifyProduct'])->name('modify-product');
    Route::post('delete-product', [ProductController::class, 'deleteProduct'])->name('delete-product');
    Route::post('change-product-status', [ProductController::class, 'changeProductStatus'])->name('change-product-status');
    Route::post('product-action', [ProductController::class, 'productAction'])->name('product-action');
    Route::post('del-product-image', [ProductController::class, 'delProductImage'])->name('del-product-image');
    // NYC Canlender Section
    Route::get('nyc-calender', [NYCCalender::class, 'nycCalender'])->name('nyc-calender');
    Route::get('add-calender', [NYCCalender::class, 'addCalender'])->name('add-calender');
    Route::get('modify-calender/{id}', [NYCCalender::class, 'modifyCalender'])->name('modify-calender');
    Route::post('change-calender-status', [NYCCalender::class, 'changeCalenderStatus'])->name('change-calender-status');
    Route::post('delete-calender', [NYCCalender::class, 'deleteCalender'])->name('delete-calender');
    Route::post('calender-action', [NYCCalender::class, 'calenderAction'])->name('calender-action');
    // Online Shirts
    Route::get('online-shirts', [ShirtController::class, 'shirts'])->name('shirt');
    Route::get('add-shirt', [ShirtController::class, 'addShirt'])->name('add-shirt');
    Route::get('modify-shirt/{id}', [ShirtController::class, 'modifyShirt'])->name('modify-shirt');
    Route::post('change-shirt-status', [ShirtController::class, 'changeShirtStatus'])->name('change-shirt-status');
    Route::post('delete-shirt', [ShirtController::class, 'deleteShirt'])->name('delete-shirt');
    Route::post('shirt-action', [ShirtController::class, 'shirtAction'])->name('shirt-action');
    // Contact Address
    Route::get('contact-address', [ContactAddress::class, 'contactAddress'])->name('contact-address');
    Route::get('add-contact', [ContactAddress::class, 'addContact'])->name('add-contact');
    Route::get('modify-contact/{id}', [ContactAddress::class, 'modifyContact'])->name('modify-contact');
    Route::post('change-contact-status', [ContactAddress::class, 'changeContactStatus'])->name('change-contact-status');
    Route::post('delete-contact', [ContactAddress::class, 'deleteContact'])->name('delete-contact');
    Route::post('contact-action', [ContactAddress::class, 'ContactAction'])->name('contact-action');
    // Newsletter
    Route::get('newsletter-email', [NewsLetterController::class, 'newsletter'])->name('newsletter-email');
    Route::get('bulk-upload-csv', [NewsLetterController::class, 'bulkUpload'])->name('bulk-upload-csv');
    Route::post('bulk-upload-csv-action', [NewsLetterController::class, 'bulkUploadAction'])->name('bulk-upload-csv-action');
    Route::get('add-newsletter-email', [NewsLetterController::class, 'addNewsletter'])->name('add-newsletter');
    Route::get('modify-newsletter-email/{id}', [NewsLetterController::class, 'modifyNewsletter'])->name('modify-newsletter');
    Route::post('change-newsletter-status', [NewsLetterController::class, 'changeNewsletterStatus'])->name('change-newsletter-status');
    Route::post('delete-newsletter', [NewsLetterController::class, 'deleteNewsletter'])->name('delete-newsletter');
    Route::post('newsletter-action', [NewsLetterController::class, 'newsletterAction'])->name('newsletter-action');
    Route::get('send-newsletter-email', [NewsLetterController::class, 'sendNewsLetterEmail'])->name('send-newsletter-email');
    Route::get('get-prev-mail-data/{id}', [NewsLetterController::class, 'prevMailData'])->name('get-prev-mail-data');
    Route::post('send-newsletter-email-action', [NewsLetterController::class, 'sendNewsLetterEmailAction'])->name('send-newsletter-email-action');
    Route::post('delete-sended-email', [NewsLetterController::class, 'deleteSendedMail'])->name('delete-sended-email');
    // User
    Route::get('users', [UserInfoController::class, 'users'])->name('users');
    Route::get('add-user', [UserInfoController::class, 'addUser'])->name('add-user');
    Route::get('modify-user/{id}', [UserInfoController::class, 'modifyUser'])->name('modify-user');
    Route::post('change-user-status', [UserInfoController::class, 'changeUserStatus'])->name('change-user-status');
    Route::post('delete-user', [UserInfoController::class, 'deleteUser'])->name('delete-user');
    Route::post('user-action', [UserInfoController::class, 'userAction'])->name('user-action');
    Route::get('export-user', [UserInfoController::class, 'exportUser'])->name('export-user');
    Route::post('export-user-action', [UserInfoController::class, 'exportUserAction'])->name('export-user-action');
    Route::get('export-user-d', [UserInfoController::class, 'download'])->name('export-user-d');
    // Email
    Route::get('email-templates/{type}', [EmailTemplateController::class, 'emailTemplates'])->name('email-templates');
    Route::post('email-templates-action', [EmailTemplateController::class, 'emailTemplatesAction'])->name('email-templates-action');
    // Appointment
    Route::get('appointment', [AppointmentController::class, 'appointments'])->name('appointment');
    Route::get('pending_appointment', [AppointmentController::class, 'pendingAppointments'])->name('pending_appointment');
    Route::get('expired_appointments', [AppointmentController::class, 'expireedAppointments'])->name('expired_appointments');
    Route::get('export-appointments-lists', [AppointmentController::class, 'exportAppointments'])->name('export-appointments-lists');
    Route::get('modify-appointment/{id}', [AppointmentController::class, 'modifyAppointment'])->name('modify-appointment');
    Route::post('modify-appointment-action', [AppointmentController::class, 'modifyAppointmentAction'])->name('modify-appointment-action');
    Route::post('cancle_appointment', [AppointmentController::class, 'cancleAppointment'])->name('cancle_appointment');
    Route::post('delete-appointment', [AppointmentController::class, 'deleteAppointment'])->name('delete-appointment');
    // Order Summery
    Route::get('orders', [OrdersController::class, 'orders'])->name('orders');
    Route::get('sales-orders', [OrdersController::class, 'salesOrders'])->name('sales-orders');
    Route::get('order-summery', [OrdersController::class, 'orderSummery'])->name('order-summery');
});
