<nav class="top-bar sticky" data-topbar role="navigation">
  <ul class="title-area">
    <li class="name">
      <h1>
        <a id="logo" href="{{ url('/') }}">
          @if(session('store_user'))
          {{ App\User::find(session('store_user'))->name }}
          @else
          Microbrander
          @endif
        </a>
      </h1>
    </li>
    <li class="toggle-topbar menu-icon">
      <a href="javascript:void(0)"><span>{{ trans('app.menu') }}</span></a>
    </li>
  </ul>

  <section class="top-bar-section">
    <ul class="right">
      <li class="has-dropdown">
        <a>
          <div class="clearfix">
            <span class="flag left flag-icon-background flag-icon-{{ App::getLocale() == 'en' ? 'gb' : App::getLocale() }}">&nbsp; &nbsp; &nbsp;</span>
            <span class="show-for-small-only">
              &nbsp; {{ config('app.locales')[App::getLocale()] }}
            </span>
          </div>
        </a>
        <ul class="dropdown">
          @foreach (config('app.locales') as $locale => $display)
            <li {!! App::getLocale() == $locale ? 'class="active"' : '' !!}>
              <a href="{{ url("/language/$locale") }}">
                <span class="flag flag-icon-background flag-icon-{{ $locale == 'en' ? 'gb' : $locale }}">&nbsp; &nbsp; &nbsp;</span>
                {{ $display }}
              </a>
            </li>
          @endforeach
        </ul>
      </li>
      <li>
        @if(Auth::check())
        <a href="{{ action('Auth\AuthController@getLogout') }}">
          {{ Auth::user()->name }}
        </a>
        @else
        <a href="{{ action('Auth\AuthController@getIndex') }}">
          <i class="fa fa-sign-in"></i>
          {{ trans('app.login') }}
        </a>
        @endif
      </li>
      <li>
        <a href="{{ action('CartController@index') }}"
          style="position: relative; padding-right: 4rem;">
          <i class="fa fa-shopping-cart"></i>
          {{ trans('app.cart') }}
          @if(!Cart::isEmpty())
          <div id="cart">
            {{ Cart::getContent()->count() }}
          </div>
          @endif
        </a>
      </li>
    </ul>
    <ul class="left">
      <li class="{{ Request::is('templates/*') ? 'active' : '' }}">
        <a href="{{ action('TemplateController@index') }}">{{ trans('Templates') }}</a>
      </li>
      <li class="{{ Request::is('products/*') ? 'active' : '' }}">
        <a href="{{ action('ProductController@index') }}">{{ trans('Products') }}</a>
      </li>
    </ul>
  </section>
</nav>