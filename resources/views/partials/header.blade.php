<div class="primary-header" role="navigation">
    <div class="container">
        <div class="primary-header__title">
            <button type="button" class="primary-header__toggle" data-toggle="collapse"
                    data-target=".primary-header__collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/" class="logo"><h1>Symposium</h1></a>
        </div>
        <div class="primary-header__collapse">
            @include('partials.nav')
        </div>
        <!--/.navbar-collapse -->
    </div>
</div>

@include('partials.flash-messages')
