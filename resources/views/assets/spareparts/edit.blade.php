<x-app-layout>
  

    <div class="py-6">
        <div class="w-full space-y-6 px-6 lg:px-10 xl:px-14">
            <x-flash-message />

            <div class="rounded-[32px] bg-gradient-to-r from-[#0B1F3A] via-[#123B6D] to-[#1E4F8A] p-8 text-white shadow-2xl">
                <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-4xl font-black">Edit Master Sparepart</h1>
                        <p class="mt-2 text-sm text-blue-100">{{ $sparepart->sparepart_name }}</p>
                    </div>

                    <a href="{{ route('assets.spareparts.show', $sparepart) }}"
                       class="rounded-2xl border border-white/20 bg-white/10 px-6 py-3 text-sm font-black text-white">
                        Detail
                    </a>
                </div>
            </div>

            <div class="overflow-hidden rounded-[32px] bg-white shadow-sm ring-1 ring-slate-200">
                <div class="border-b bg-slate-50 px-7 py-5">
                    <h3 class="text-xl font-black text-[#0B1F3A]">Form Edit Sparepart</h3>
                </div>

                <form method="POST" action="{{ route('assets.spareparts.update', $sparepart) }}" class="space-y-6 p-7">
                    @csrf
                    @method('PUT')
                    @include('assets.spareparts.partials.form', ['sparepart' => $sparepart])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>