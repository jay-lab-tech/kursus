# Fitur Risalah/Notula - Dokumentasi

## Overview
Risalah (Notula/Meeting Minutes) adalah fitur untuk instruktur mengelola dan mendokumentasikan ringkasan pertemuan/pembelajaran di setiap kelas. Fitur ini dirancang khusus untuk instruktur dengan akses terbatas berbasis role.

## Database
### Table: risalah
```sql
- id (Primary Key)
- kelas_id (Foreign Key → kelas.id)
- instruktur_id (Foreign Key → instruktur.id)
- tanggal (Date)
- judul (String)
- isi (Text)
- catatan_penting (Text, nullable)
- peserta_hadir (Integer)
- file (Text, nullable) - untuk attachment di masa depan
- status (Enum: 'draft', 'published')
- timestamps (created_at, updated_at)
```

## Model & Relationships

### Risalah Model
`Modules\Academic\Models\Risalah`

**Relationships:**
- `belongsTo(Kelas::class)` - Risalah terkait dengan satu kelas
- `belongsTo(Instruktur::class)` - Dibuat oleh satu instruktur

**Attributes:**
- Fillable: kelas_id, instruktur_id, tanggal, judul, isi, catatan_penting, peserta_hadir, file, status
- Casts: tanggal as date, peserta_hadir as integer

### Model Updates
- **Kelas Model**: Added `hasMany(Risalah::class)` relationship
- **Instruktur Model**: Added `hasMany(Risalah::class)` relationship

## Controller

### RisalahController
`Modules\Academic\Http\Controllers\RisalahController`

**Methods:**
1. `index()` - Get all risalah for current instruktur with filtering/search
   - Query Parameters: search, kelas_id, status, sort_by, sort_order, per_page
   - Authorization: Current user must be instruktur

2. `show($id)` - Get specific risalah detail
   - Authorization: Only owner instruktur can view

3. `store(Request $request)` - Create new risalah
   - Required: kelas_id, tanggal, judul, isi, peserta_hadir
   - Optional: catatan_penting, status
   - Validation: Required fields validated, kelas must belong to current instruktur

4. `update(Request $request, $id)` - Update existing risalah
   - Authorization: Only owner instruktur can update
   - Partial updates supported

5. `destroy($id)` - Delete risalah
   - Authorization: Only owner instruktur can delete

6. `getByKelas($kelasId)` - Get published risalah for a class
   - Public endpoint (available for students to view)

7. `getKelasForInstruktur()` - Get list of kelas managed by current instruktur
   - Helper endpoint for form dropdowns

## Routes

### API Routes (routes/api.php)
```php
// Protected by 'auth:sanctum' and 'role.authorize:instruktur'
Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('role.authorize:instruktur')->group(function () {
        Route::get('/risalah', [RisalahController::class, 'index']);
        Route::post('/risalah', [RisalahController::class, 'store']);
        Route::get('/risalah/{id}', [RisalahController::class, 'show']);
        Route::put('/risalah/{id}', [RisalahController::class, 'update']);
        Route::delete('/risalah/{id}', [RisalahController::class, 'destroy']);
        Route::get('/risalah/kelas/list', [RisalahController::class, 'getKelasForInstruktur']);
    });
    
    // Public endpoint (anyone authenticated)
    Route::get('/risalah/kelas/{kelasId}', [RisalahController::class, 'getByKelas']);
});
```

### Web Routes (routes/web.php)
```php
// Instruktur risalah management pages
Route::get('risalah', function () {
    return view('academic.risalah-list');
})->name('risalah-list');

Route::get('risalah/create', function () {
    return view('academic.risalah-form');
})->name('risalah-create');

Route::get('risalah/{id}/edit', function () {
    return view('academic.risalah-form');
})->name('risalah-edit');

Route::get('risalah/{id}', function () {
    return view('academic.risalah-detail');
})->name('risalah-detail');
```

## Views

### 1. risalah-list.blade.php
**Path:** `resources/views/academic/risalah-list.blade.php`

**Features:**
- Responsive grid layout dengan card-based design
- Search functionality
- Filter by kelas dan status
- Pagination
- Quick actions: View, Edit, Delete
- Empty state handling
- Loading indicator
- Status badges (Draft/Published)

**JavaScript Functions:**
- `loadRisalah()` - Fetch risalah dengan filter/search
- `loadKelasOptions()` - Populate kelas dropdown
- `deleteRisalah(id)` - Delete with confirmation
- `renderRisalahCards()` - Render card UI
- `renderPagination()` - Handle pagination

### 2. risalah-form.blade.php
**Path:** `resources/views/academic/risalah-form.blade.php`

**Features:**
- Create mode: Empty form untuk risalah baru
- Edit mode: Pre-populate form dengan data existing
- Form fields:
  - Kelas (dropdown, required)
  - Tanggal (date picker, required)
  - Judul/Topik (text, max 255 chars)
  - Isi Risalah (textarea, required)
  - Peserta Hadir (number, required)
  - Status (draft/published)
  - Catatan Penting (textarea, optional)
- Character counters untuk text fields
- Form validation dengan error messages
- Auto-save detection

**JavaScript Functions:**
- `loadKelas()` - Fetch available kelas
- `loadRisalahForEdit()` - Load existing risalah data
- `handleFormSubmit()` - Save via API (create or update)
- `updateCharacterCounts()` - Update char counters

### 3. risalah-detail.blade.php
**Path:** `resources/views/academic/risalah-detail.blade.php`

**Features:**
- Full detail view dengan gradient header
- Display sections:
  - Kelas info
  - Tanggal
  - Jumlah peserta hadir
  - Instruktur card dengan inisial avatar
  - Isi risalah dengan formatting
  - Catatan penting (if available)
- Action buttons: Edit, Delete, Back
- Status badge
- Loading state
- Error handling

**JavaScript Functions:**
- `loadRisalah()` - Fetch risalah detail
- `displayRisalah()` - Render detail view
- `editRisalah()` - Navigate to edit page
- `deleteRisalah()` - Delete with confirmation

## Security & Authorization

### Role-Based Access Control
- **Instruktur Only**: 
  - Create risalah
  - Edit own risalah
  - Delete own risalah
  - View own risalah list
  
- **Authorization Check**:
  - Each risalah belongs to specific instruktur via `instruktur_id`
  - Controller validates `instruktur->user_id === Auth::user()->id` before edit/delete
  
- **Public Endpoints**:
  - Students can view published risalah for their enrolled kelas via `/api/risalah/kelas/{kelasId}`

## Usage Flow

### For Instruktur

1. **Navigate to Risalah Management**
   - Go to `/risalah`

2. **Create New Risalah**
   - Click "Buat Risalah Baru" button
   - Navigate to `/risalah/create`
   - Fill form:
     - Select kelas
     - Set tanggal
     - Input judul
     - Write isi (meeting minutes)
     - Input peserta_hadir
     - Optional: add catatan_penting
     - Choose status (draft or publish immediately)
   - Submit → Redirects to risalah list

3. **Edit Risalah**
   - From list, click "Edit" button
   - Navigate to `/risalah/{id}/edit`
   - Form pre-populated with existing data
   - Modify fields
   - Submit → Updates and redirects to list

4. **View Risalah**
   - From list, click "Lihat" button
   - Navigate to `/risalah/{id}`
   - View full detail

5. **Delete Risalah**
   - From list or detail, click "Hapus"
   - Confirm deletion
   - Removed from database

### For Students

1. **View Published Risalah**
   - When viewing kelas detail
   - Can see published risalah for that kelas
   - Read-only access to content

## API Response Examples

### List Risalah
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "kelas_id": 5,
      "instruktur_id": 2,
      "tanggal": "2026-01-29",
      "judul": "Pertemuan Database Design",
      "isi": "Membahas normalisasi database...",
      "catatan_penting": "Homework di assign",
      "peserta_hadir": 28,
      "status": "published",
      "created_at": "2026-01-29T...",
      "updated_at": "2026-01-29T...",
      "kelas": {...},
      "instruktur": {...}
    }
  ],
  "pagination": {
    "total": 15,
    "per_page": 15,
    "current_page": 1,
    "last_page": 1
  }
}
```

### Create Risalah (Request)
```json
{
  "kelas_id": 5,
  "tanggal": "2026-01-29",
  "judul": "Pertemuan Database Design",
  "isi": "Membahas normalisasi database...",
  "peserta_hadir": 28,
  "catatan_penting": "Homework di assign",
  "status": "published"
}
```

## Future Enhancements

1. **File Attachment**
   - Store meeting materials/documents
   - PDF, DOC, PPT support

2. **Attendance Tracking**
   - Link risalah to mahasiswa attendance records
   - Track who was present vs absent

3. **Integration with Jadwal**
   - Auto-create risalah template based on jadwal
   - Link to specific meeting time

4. **Email Notifications**
   - Notify mahasiswa when risalah published
   - Send to enrolled students

5. **Archive & Export**
   - Export risalah to PDF
   - Archive per semester

6. **Rich Text Editor**
   - WYSIWYG editor for isi field
   - Support formatting, links, images

7. **Approval Workflow**
   - Admin review before publishing
   - Compliance tracking

## Testing

To test the feature:

1. **Create Test Data**
   ```bash
   php artisan tinker
   > $instruktur = Instruktur::find(1);
   > $kelas = Kelas::where('instruktur_id', $instruktur->id)->first();
   ```

2. **Test API Endpoints**
   ```bash
   curl -H "Authorization: Bearer {token}" http://localhost/api/risalah
   ```

3. **Test Web Pages**
   - Visit `/risalah` as instruktur
   - Create, edit, delete risalah
   - Verify status changes
   - Check student access to published risalah
