@include('facility.master-rooms.form', [
    'title' => 'Edit Ruangan',
    'subtitle' => 'Perbarui data master ruangan.',
    'action' => route('master-rooms.update', $room),
    'method' => 'PUT',
    'room' => $room,
])