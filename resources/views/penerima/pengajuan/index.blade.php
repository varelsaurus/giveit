<form action="{{ route('admin.pengajuan.approve', $pengajuan->id) }}" method="POST">
    @csrf
    
    {{-- Pilih Kurir --}}
    <select name="kurir_id" required>
        <option value="">Pilih Kurir</option>
        @foreach($kurirs as $kurir)
            <option value="{{ $kurir->id }}">{{ $kurir->name }}</option>
        @endforeach
    </select>

    {{-- Pilih Tanggal --}}
    <input type="datetime-local" name="tanggal_ambil" required>

    <button type="submit">Setujui & Tugaskan</button>
</form>