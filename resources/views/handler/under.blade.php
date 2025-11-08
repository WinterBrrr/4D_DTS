{{-- Handler Under Review (Table) --}}
@push('head')
<style>
  header.sticky { display: none !important; }
</style>
@endpush
<x-layouts.app :title="'Under Review'">
    <div class="mx-auto w-full max-w-[1400px] px-4 py-6 flex gap-6">
        @include('partials.handler-sidebar')
        <div class="flex-1">
            <!-- Header -->
            {{-- Copy content from admin/under.blade.php and adjust for handler as needed --}}
        </div>
    </div>
</x-layouts.app>
