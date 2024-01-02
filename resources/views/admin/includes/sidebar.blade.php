  <!-- Start::app-sidebar -->
  <aside class="app-sidebar" id="sidebar">
      <!-- Start::main-sidebar-header -->
      <div class="main-sidebar-header">
          <a href="{{ route('home') }}" class="header-logo">
              <img src="{{ asset('storage/general_setting/' . $adminLogo ?? '') }}" alt="logo"
                  class="main-logo mx-auto" />
              {{-- @if ($adminLogo)
                  <img src="{{ asset('storage/general_setting/' . $adminLogo ?? '') }}" alt="logo"
                      class="main-logo desktop-logo" />
                  <img src="{{ asset('admin/images/brand-logos/toggle-logo.png') }}" alt="logo"
                      class="main-logo toggle-logo" />
              @else
                  <img src="{{ asset('admin/images/brand-logos/toggle-logo.png') }}" alt="logo"
                      class="main-logo toggle-logo" />
              @endif
              @if ($adminLogo)
                  <img src="{{ asset('storage/general_setting/' . $adminLogo ?? '') }}" alt="logo"
                      class="main-logo desktop-logo" />
              @else
                  <img src="{{ asset('admin/images/brand-logos/toggle-logo.png') }}" alt="logo"
                      class="main-logo toggle-logo" />
              @endif --}}
              {{-- <img src="{{ asset('admin/images/brand-logos/toggle-dark.png') }}" alt="logo"
                  class="main-logo toggle-dark" /> --}}
          </a>
      </div>
      <!-- End::main-sidebar-header -->

      <!-- Start::main-sidebar -->
      <div class="main-sidebar" id="sidebar-scroll">
          <!-- Start::nav -->
          <nav class="main-menu-container nav nav-pills flex-column sub-open">
              <div class="slide-left" id="slide-left">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                      viewBox="0 0 24 24">
                      <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                  </svg>
              </div>
              <ul class="main-menu">
                  <!-- Start::slide__category -->
                  {{-- <li class="slide__category">
                    <span class="category-name">Main</span>
                </li> --}}
                  <!-- End::slide__category -->

                  <!-- Start::slide -->
                  <li class="slide">
                      <a href="{{ route('dashboard') }}"
                          class="side-menu__item  {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                          <i class="ri-home-8-line"></i>
                          <span class="side-menu__label">Dashboard</span>
                      </a>
                  </li>
                  <!-- End::slide -->

                  <!-- Start::slide -->
                  <li class="slide">
                      <a href="{{ route('pages') }}"
                          class="side-menu__item  {{ request()->routeIs('pages') ? 'active' : '' }}">
                          <i class="ti ti-box-multiple"></i>
                          <span class="side-menu__label">Pages</span>
                      </a>
                  </li>
                  <!-- End::slide -->

                  <!-- Start::slide -->
                  <li class="slide">
                      <a href="{{ route('homepage-slider') }}"
                          class="side-menu__item {{ request()->routeIs('homepage-slider') ? 'active' : '' }}">
                          <i class="ti ti-slideshow"></i>
                          <span class="side-menu__label">Homepage Slider</span>
                      </a>
                  </li>
                  <!-- End::slide -->

                  <!-- Start::slide -->
                  <li class="slide">
                      <a href="{{ route('faq-section') }}"
                          class="side-menu__item {{ request()->routeIs('faq-section') ? 'active' : '' }}">
                          <i class="ti ti-question-mark"></i>
                          <span class="side-menu__label">FAQ</span>
                      </a>
                  </li>
                  <!-- End::slide -->

                  <!-- Start::slide -->
                  <li class="slide">
                      <a href="{{ route('events') }}"
                          class="side-menu__item {{ request()->routeIs('events') ? 'active' : '' }}">
                          <i class="ti ti-calendar-event"></i>
                          <span class="side-menu__label">Events</span>
                      </a>
                  </li>
                  <!-- End::slide -->

                  <!-- Start::slide -->
                  <li class="slide">
                      <a href="{{ route('contact-address') }}"
                          class="side-menu__item {{ request()->routeIs('contact-address') ? 'active' : '' }}">
                          <i class="ti ti-address-book"></i>
                          <span class="side-menu__label">Contact Address</span>
                      </a>
                  </li>
                  <!-- End::slide -->

                  <!-- Start::slide -->
                  <li
                      class="slide has-sub {{ request()->routeIs('users') || request()->routeIs('export-user') ? 'open' : '' }}">
                      <a href="javascript:void(0);"
                          class="side-menu__item {{ request()->routeIs('users') || request()->routeIs('export-user') ? 'active' : '' }}">
                          <i class="ti ti-shirt side-menu__icon"></i>
                          <span class="side-menu__label">Users</span>
                          <i class="ri ri-arrow-right-s-line side-menu__angle"></i>
                      </a>
                      <ul class="slide-menu child1">
                          <li class="slide">
                              <a href="{{ route('users') }}"
                                  class="side-menu__item {{ request()->routeIs('users') ? 'active' : '' }}">Users</a>
                          </li>
                          <li class="slide">
                              <a href="{{ route('export-user') }}"
                                  class="side-menu__item {{ request()->routeIs('export-user') ? 'active' : '' }}">Export
                                  Users Data</a>
                          </li>
                      </ul>
                  </li>
                  <!-- End::slide -->

                  <!-- Start::slide -->
                  <li
                      class="slide has-sub {{ request()->routeIs('category') || request()->routeIs('products') ? 'open' : '' }}">
                      <a href="javascript:void(0);"
                          class="side-menu__item {{ request()->routeIs('category') || request()->routeIs('products') ? 'active' : '' }}">
                          <i class="ti ti-shirt side-menu__icon"></i>
                          <span class="side-menu__label">Products</span>
                          <i class="ri ri-arrow-right-s-line side-menu__angle"></i>
                      </a>
                      <ul class="slide-menu child1">
                          <li class="slide">
                              <a href="{{ route('category') }}"
                                  class="side-menu__item {{ request()->routeIs('category') ? 'active' : '' }}">Category</a>
                          </li>
                          <li class="slide">
                              <a href="{{ route('products') }}"
                                  class="side-menu__item {{ request()->routeIs('products') ? 'active' : '' }}">Products</a>
                          </li>
                      </ul>
                  </li>
                  <!-- End::slide -->

                  <!-- Start::slide -->
                  <li class="slide">
                      <a href="{{ route('shirt') }}"
                          class="side-menu__item {{ request()->routeIs('shirt') ? 'active' : '' }}">
                          <i class="ti ti-shirt-filled"></i>
                          <span class="side-menu__label">Online Shirts</span>
                      </a>
                  </li>
                  <!-- End::slide -->

                  <!-- Start::slide -->
                  <li class="slide">
                      <a href="{{ route('discount') }}"
                          class="side-menu__item {{ request()->routeIs('discount') ? 'active' : '' }}">
                          <i class="ti ti-discount-2"></i>
                          <span class="side-menu__label">Vouchers</span>
                      </a>
                  </li>
                  <!-- End::slide -->

                  <!-- Start::slide -->
                  <li class="slide has-sub">
                      <a href="javascript:void(0);" class="side-menu__item">
                          <i class="ti ti-garden-cart side-menu__icon"></i>
                          <span class="side-menu__label">Orders Report</span>
                          <i class="ri ri-arrow-right-s-line side-menu__angle"></i>
                      </a>
                      <ul class="slide-menu child1">
                          <li class="slide">
                              <a href="{{ route('orders') }}" class="side-menu__item">Orders
                                  Lists</a>
                          </li>
                          <li class="slide">
                              <a href="{{ route('sales-orders') }}" class="side-menu__item">Sales
                                  Report</a>
                          </li>
                          <li class="slide">
                              <a href="{{ route('order-summery') }}" class="side-menu__item">Report Summary</a>
                          </li>
                      </ul>
                  </li>
                  <!-- End::slide -->

                  <!-- Start::slide -->
                  <li class="slide">
                      <a href="{{ route('nyc-calender') }}"
                          class="side-menu__item {{ request()->routeIs('nyc-calender') ? 'active' : '' }}">
                          <i class="ti ti-calendar-due"></i>
                          <span class="side-menu__label">NYC Calender</span>
                      </a>
                  </li>
                  <!-- End::slide -->

                  <!-- Start::slide -->
                  <li
                      class="slide has-sub {{ (request()->routeIs('appointment') || request()->routeIs('pending_appointment') || request()->routeIs('expired_appointments') ? 'active' : '') ? 'open' : '' }}">
                      <a href="javascript:void(0);"
                          class="side-menu__item {{ request()->routeIs('appointment') || request()->routeIs('pending_appointment') || request()->routeIs('expired_appointments') ? 'active' : '' }}">
                          <i class="ti ti-shirt side-menu__icon"></i>
                          <span class="side-menu__label">Appointments</span>
                          <i class="ri ri-arrow-right-s-line side-menu__angle"></i>
                      </a>
                      <ul class="slide-menu child1">
                          <li class="slide">
                              <a href="{{ route('appointment') }}"
                                  class="side-menu__item {{ request()->routeIs('appointment') ? 'active' : '' }}">Upcomming
                                  Appointments</a>
                          </li>
                          <li class="slide">
                              <a href="{{ route('pending_appointment') }}"
                                  class="side-menu__item {{ request()->routeIs('pending_appointment') ? 'active' : '' }}">Pending
                                  Appointments</a>
                          </li>
                          <li class="slide">
                              <a href="{{ route('expired_appointments') }}"
                                  class="side-menu__item {{ request()->routeIs('expired_appointments') ? 'active' : '' }}">Expired
                                  / Calcled</a>
                          </li>
                      </ul>
                  </li>
                  <!-- End::slide -->

                  <!-- Start::slide -->
                  <li class="slide has-sub {{ request()->routeIs('email-templates') ? 'open' : '' }}">
                      <a href="javascript:void(0);"
                          class="side-menu__item {{ request()->routeIs('email-templates') ? 'active' : '' }}">
                          <i class="ti ti-mail side-menu__icon"></i>
                          <span class="side-menu__label">Emails</span>
                          <i class="ri ri-arrow-right-s-line side-menu__angle"></i>
                      </a>
                      <ul class="slide-menu child1">
                          <span class="li-place-holder-custom">User Account Email</span>
                          <li class="slide">
                              <a href="{{ route('email-templates', ['type' => 'waiting_activation']) }}"
                                  class="side-menu__item {{ request('type') === 'waiting_activation' ? 'active' : '' }}">
                                  New - Waiting For Activation
                              </a>
                          </li>
                          <li class="slide">
                              <a href="{{ route('email-templates', ['type' => 'acc_activated']) }}"
                                  class="side-menu__item {{ request('type') === 'acc_activated' ? 'active' : '' }}">Active</a>
                          </li>
                          <li class="slide">
                              <a href="{{ route('email-templates', ['type' => 'acc_suspended']) }}"
                                  class="side-menu__item {{ request('type') === 'acc_suspended' ? 'active' : '' }}">Inactive/Suspended</a>
                          </li>
                          <li class="slide">
                              <a href="{{ route('email-templates', ['type' => 'forgot_pass']) }}"
                                  class="side-menu__item {{ request('type') === 'forgot_pass' ? 'active' : '' }}">Forgot
                                  Password Email</a>
                          </li>
                          <span class="li-place-holder-custom">System Email</span>
                          <li class="slide">
                              <a href="{{ route('email-templates', ['type' => 'enquiry']) }}"
                                  class="side-menu__item {{ request('type') === 'enquiry' ? 'active' : '' }}">Enquiry</a>
                          </li>
                          <li class="slide">
                              <a href="{{ route('email-templates', ['type' => 'subscription']) }}"
                                  class="side-menu__item {{ request('type') === 'subscription' ? 'active' : '' }}">Newsletter
                                  Subscription Email</a>
                          </li>
                          <li class="slide">
                              <a href="{{ route('email-templates', ['type' => 'apointment']) }}"
                                  class="side-menu__item {{ request('type') === 'apointment' ? 'active' : '' }}">Appoinment
                                  Email - New</a>
                          </li>
                          <li class="slide">
                              <a href="{{ route('email-templates', ['type' => 'apointment_confirmation']) }}"
                                  class="side-menu__item {{ request('type') === 'apointment_confirmation' ? 'active' : '' }}">Appoinment
                                  Confirmation Email</a>
                          </li>
                          <li class="slide">
                              <a href="{{ route('email-templates', ['type' => 'apointment_reminder']) }}"
                                  class="side-menu__item {{ request('type') === 'apointment_reminder' ? 'active' : '' }}">Appoinment
                                  Reminder Email</a>
                          </li>
                          <span class="li-place-holder-custom">Placed Order Email</span>
                          <li class="slide">
                              <a href="{{ route('email-templates', ['type' => 'new_order']) }}"
                                  class="side-menu__item {{ request('type') === 'new_order' ? 'active' : '' }}">New
                                  Order</a>
                          </li>
                          <li class="slide">
                              <a href="{{ route('email-templates', ['type' => 'dispatched']) }}"
                                  class="side-menu__item {{ request('type') === 'dispatched' ? 'active' : '' }}">Closed/Despatched</a>
                          </li>
                          <li class="slide">
                              <a href="{{ route('email-templates', ['type' => 'processing']) }}"
                                  class="side-menu__item {{ request('type') === 'processing' ? 'active' : '' }}">Processing</a>
                          </li>
                          <li class="slide">
                              <a href="{{ route('email-templates', ['type' => 'cancelled']) }}"
                                  class="side-menu__item {{ request('type') === 'cancelled' ? 'active' : '' }}">Cancelled</a>
                          </li>
                      </ul>
                  </li>
                  <!-- End::slide -->

                  <!-- Start::slide -->
                  <li
                      class="slide has-sub {{ request()->routeIs('newsletter-email') || request()->routeIs('bulk-upload-csv') || request()->routeIs('send-newsletter-email') ? 'open' : '' }}">
                      <a href="javascript:void(0);" class="side-menu__item">
                          <i class="ti ti-news side-menu__icon"></i>
                          <span class="side-menu__label">Newsletter</span>
                          <i class="ri ri-arrow-right-s-line side-menu__angle"></i>
                      </a>
                      <ul class="slide-menu child1">
                          <li class="slide">
                              <a href="{{ route('newsletter-email') }}"
                                  class="side-menu__item {{ request()->routeIs('newsletter-email') ? 'active' : '' }}">Email</a>
                          </li>
                          <li class="slide">
                              <a href="{{ route('bulk-upload-csv') }}"
                                  class="side-menu__item  {{ request()->routeIs('bulk-upload-csv') ? 'active' : '' }}">Bulk
                                  Upload - CSV</a>
                          </li>
                          <li class="slide">
                              <a href="{{ route('send-newsletter-email') }}"
                                  class="side-menu__item {{ request()->routeIs('send-newsletter-email') ? 'active' : '' }}">Send
                                  Newsletter
                                  Email</a>
                          </li>
                      </ul>
                  </li>
                  <!-- End::slide -->

                  <!-- Start::slide -->
                  <li class="slide">
                      <a href="{{ route('employee') }}"
                          class="side-menu__item {{ request()->routeIs('employee') ? 'active' : '' }}">
                          <i class="ti ti-users-group"></i>
                          <span class="side-menu__label">Employees</span>
                      </a>
                  </li>
                  <!-- End::slide -->

                  <!-- Start::slide -->
                  <li class="slide">
                      <a href="{{ route('generalSetting') }}"
                          class="side-menu__item {{ request()->routeIs('generalSetting') ? 'active' : '' }}">
                          <i class="ti ti-settings"></i>
                          <span class="side-menu__label">General Setting</span>
                      </a>
                  </li>
                  <!-- End::slide -->



              </ul>
              <div class="slide-right" id="slide-right">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                      viewBox="0 0 24 24">
                      <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z">
                      </path>
                  </svg>
              </div>
          </nav>
          <!-- End::nav -->
      </div>
      <!-- End::main-sidebar -->
  </aside>
  <!-- End::app-sidebar -->
