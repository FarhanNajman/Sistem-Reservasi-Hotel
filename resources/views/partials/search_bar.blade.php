<div class="search-bar-container" {!! isset($noMarginTop) && $noMarginTop ? 'style="margin-top: 0;"' : '' !!}>
    <form action="{{ url('/reservasi/cari') }}#kamar-section" method="GET" class="search-form" id="searchForm">
        <div class="form-group">
            <label for="check_in"><i data-lucide="calendar-input" style="width: 14px; vertical-align: middle; margin-right: 4px;"></i> Check-In</label>
            <input type="date" id="check_in" name="check_in" required value="{{ request('check_in', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}">
        </div>
        
        <div class="form-group">
            <label for="check_out"><i data-lucide="calendar-output" style="width: 14px; vertical-align: middle; margin-right: 4px;"></i> Check-Out</label>
            <input type="date" id="check_out" name="check_out" required value="{{ request('check_out', date('Y-m-d', strtotime('+1 day'))) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
        </div>

        <div class="form-group">
            <label for="lantai"><i data-lucide="layers" style="width: 14px; vertical-align: middle; margin-right: 4px;"></i> Lantai</label>
            <select id="lantai" name="lantai">
                <option value="">Semua Lantai</option>
                @foreach($roomFloors as $floor)
                    <option value="{{ $floor }}" {{ request('lantai') == $floor ? 'selected' : '' }}>Lantai {{ $floor }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="tamu"><i data-lucide="users" style="width: 14px; vertical-align: middle; margin-right: 4px;"></i> Jumlah Tamu</label>
            <select id="tamu" name="tamu">
                <option value="1" {{ request('tamu') == '1' ? 'selected' : '' }}>1 Orang</option>
                <option value="2" {{ request('tamu', '2') == '2' ? 'selected' : '' }}>2 Orang</option>
                <option value="3" {{ request('tamu') == '3' ? 'selected' : '' }}>3 Orang</option>
                <option value="4" {{ request('tamu') == '4' ? 'selected' : '' }}>4 Orang</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tipe_kamar"><i data-lucide="bed-double" style="width: 14px; vertical-align: middle; margin-right: 4px;"></i> Tipe Kamar</label>
            <select id="tipe_kamar" name="tipe_kamar">
                <option value="">Semua Tipe</option>
                @foreach($roomTypes as $type)
                    <option value="{{ $type }}" {{ request('tipe_kamar') == $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="search-submit-btn" aria-label="Cari Kamar" style="width: 50px; height: 50px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
            <i data-lucide="search" style="width: 24px; height: 24px;"></i>
        </button>
    </form>
</div>

<script>
    // Logika sederhana untuk validasi tanggal check-in & check-out
    document.addEventListener('DOMContentLoaded', function() {
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');

        if(checkInInput && checkOutInput) {
            checkInInput.addEventListener('change', function() {
                // Check-out minimal harus H+1 dari check-in
                const checkInDate = new Date(this.value);
                checkInDate.setDate(checkInDate.getDate() + 1);
                
                const nextDayString = checkInDate.toISOString().split('T')[0];
                checkOutInput.min = nextDayString;
                
                if (checkOutInput.value < nextDayString) {
                    checkOutInput.value = nextDayString;
                }
            });
        }
    });
</script>
