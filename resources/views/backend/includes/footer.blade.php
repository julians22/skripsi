<footer class="c-footer">
    <div>
        <strong>
            @lang('Copyright') &copy; 2022
            <x-utils.link href="{{ URL::to('/') }}" target="_blank" :text="__(appName())" />
        </strong>

        @lang('All Rights Reserved')
    </div>

    <div class="mfs-auto">
        @lang('Powered by')
        <x-utils.link href="{{ URL::to('/') }}" target="_blank" :text="__(appName())" />
    </div>
</footer>
