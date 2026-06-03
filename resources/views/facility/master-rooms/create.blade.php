@include('facility.master-rooms.form', [
    'title' => 'Tambah Ruangan',
    'subtitle' => 'Tambahkan master ruangan untuk kebutuhan booking.',
    'action' => route('master-rooms.store'),
    'method' => 'POST',
    'room' => null,
])