@if ($logged_in_user->hasAllAccess())
    <x-utils.link class="c-subheader-nav-link" href="#" :text="__('Deleted Transaction')" />
@endif
