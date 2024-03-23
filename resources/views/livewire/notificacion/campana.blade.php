<div>
    @if ($NAlertasCuarteles > 0)
        <span class="sr-only p-1">Open Notification panel</span>
        {{-- <svg class="animate-bounce w-6 h-6 w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg> --}}
        <i class="animate-bounce w-6 h-6 fa-solid fa-bell text-red-500"></i>
        <p class="animate-bounce w-6 h-6 text-red-500 text-bold">{{ $NAlertasCuarteles }}</p>
    @else
        <span class="sr-only m-1">Open Notification panel</span>
        {{-- <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg> --}}
        <i class="fa-solid fa-bell-slash"></i>
    @endif
</div>
