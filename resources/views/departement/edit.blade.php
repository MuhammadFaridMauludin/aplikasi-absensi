 <form action="/departement/{{ $departement->kode_dep }}/update" method="POST" id="frmDepartement">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                 <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-braille"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 5a1 1 0 1 0 2 0a1 1 0 0 0 -2 0z" /><path d="M7 5a1 1 0 1 0 2 0a1 1 0 0 0 -2 0z" /><path d="M7 19a1 1 0 1 0 2 0a1 1 0 0 0 -2 0z" /><path d="M16 12h.01" /><path d="M8 12h.01" /><path d="M16 19h.01" /></svg>
                                </span>
                                <input type="text" id="kode_dep" value="{{ $departement->kode_dep }}" class="form-control" name="kode_dep" placeholder="Kode Departement" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path></svg>
                                </span>
                                <input type="text" id="nama_dep" value="{{ $departement->nama_dep}}" class="form-control" name="nama_dep" placeholder="Nama departement">
                    </div>
                </div>
            </div>
           
           <div class="row mt-2">
            <div class="col-12">
                <div class="form-group">
                    <button class="btn btn-primary w-100"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-send"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 14l11 -11" /><path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" /></svg>
                        Simpan Data</button>
                </div>
            </div>
           </div>
          </form>