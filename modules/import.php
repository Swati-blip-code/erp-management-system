<?php include_once 'includes/data.php'; ?>

<div class="page-header">
    <div>
        <h2 class="page-title">Import / Export Data</h2>
        <p class="page-sub">Bulk import student data or export reports in multiple formats.</p>
    </div>
</div>

<div class="ie-grid">
    <!-- Import Section -->
    <div class="ie-card">
        <div class="ie-header import">
            <div class="ie-icon"><i class="fas fa-file-import"></i></div>
            <div>
                <h3>Import Data</h3>
                <p>Upload CSV or Excel files to bulk add records</p>
            </div>
        </div>
        <div class="ie-body">
            <div class="upload-zone" id="dropZone" onclick="document.getElementById('fileInput').click()" ondragover="event.preventDefault();this.classList.add('dragover')" ondragleave="this.classList.remove('dragover')" ondrop="handleDrop(event)">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Drag & drop files here, or <strong>click to browse</strong></p>
                <span>Supports: .csv, .xlsx, .xls</span>
                <input type="file" id="fileInput" accept=".csv,.xlsx,.xls" style="display:none" onchange="handleFile(this)">
            </div>
            <div class="import-options">
                <h4>Import Options</h4>
                <div class="option-row">
                    <label class="checkbox-label"><input type="checkbox" checked> Skip duplicate records</label>
                    <label class="checkbox-label"><input type="checkbox"> Update existing records</label>
                    <label class="checkbox-label"><input type="checkbox" checked> Send welcome email</label>
                </div>
                <div class="form-group" style="margin-top:1rem">
                    <label>Import As</label>
                    <select class="filter-select"><option>Students</option><option>Staff</option><option>Grades</option><option>Attendance</option></select>
                </div>
            </div>
            <button class="btn-primary full-width" onclick="simulateImport()"><i class="fas fa-upload"></i> Start Import</button>
        </div>
    </div>

    <!-- Export Section -->
    <div class="ie-card">
        <div class="ie-header export">
            <div class="ie-icon"><i class="fas fa-file-export"></i></div>
            <div>
                <h3>Export Data</h3>
                <p>Download records as CSV, Excel, or PDF</p>
            </div>
        </div>
        <div class="ie-body">
            <div class="export-list">
                <?php
                $exports = [
                    ['label'=>'Student List','icon'=>'fa-user-graduate','color'=>'blue','count'=>count(getStudents())],
                    ['label'=>'Attendance Report','icon'=>'fa-calendar-check','color'=>'green','count'=>count(getAttendance())],
                    ['label'=>'Grade Sheet','icon'=>'fa-chart-bar','color'=>'purple','count'=>count(getGrades())],
                    ['label'=>'Full ERP Report','icon'=>'fa-file-pdf','color'=>'red','count'=>'All'],
                ];
                foreach($exports as $e):
                ?>
                <div class="export-item">
                    <div class="export-icon <?= $e['color'] ?>"><i class="fas <?= $e['icon'] ?>"></i></div>
                    <div class="export-info">
                        <strong><?= $e['label'] ?></strong>
                        <span><?= $e['count'] ?> records</span>
                    </div>
                    <div class="export-btns">
                        <button class="btn-xs btn-blue" onclick="exportData('csv','<?= $e['label'] ?>')">CSV</button>
                        <button class="btn-xs btn-green" onclick="exportData('xlsx','<?= $e['label'] ?>')">Excel</button>
                        <button class="btn-xs btn-red" onclick="exportData('pdf','<?= $e['label'] ?>')">PDF</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Sample Template Download -->
            <div class="template-box">
                <i class="fas fa-file-csv"></i>
                <div>
                    <strong>Download Sample Template</strong>
                    <p>Use this CSV template for bulk import</p>
                </div>
                <button class="btn-secondary" onclick="downloadTemplate()"><i class="fas fa-download"></i> Download</button>
            </div>
        </div>
    </div>
</div>

<!-- Import Progress Modal -->
<div class="modal-overlay" id="importModal">
    <div class="modal modal-sm">
        <div class="modal-header">
            <h3>Importing Data...</h3>
        </div>
        <div class="modal-form">
            <div class="import-progress">
                <div class="progress-bar-lg"><div class="progress-fill-lg" id="importBar"></div></div>
                <p id="importStatus">Reading file...</p>
            </div>
        </div>
    </div>
</div>

<script>
function simulateImport(){
    openModal('importModal');
    const bar = document.getElementById('importBar');
    const status = document.getElementById('importStatus');
    const msgs = ['Reading file...','Validating records...','Checking duplicates...','Inserting data...','Done!'];
    let p=0, i=0;
    const iv = setInterval(()=>{
        p+=20; bar.style.width=p+'%';
        status.textContent = msgs[i++]||'Done!';
        if(p>=100){clearInterval(iv); setTimeout(()=>{closeModal('importModal'); showToast('Import complete! Records added successfully.');},600);}
    },600);
}
function handleFile(i){if(i.files[0]) document.getElementById('dropZone').querySelector('p').innerHTML='<strong>'+i.files[0].name+'</strong> selected';}
function handleDrop(e){e.preventDefault();document.getElementById('dropZone').classList.remove('dragover');if(e.dataTransfer.files[0]){document.getElementById('dropZone').querySelector('p').innerHTML='<strong>'+e.dataTransfer.files[0].name+'</strong> selected';}}
function exportData(fmt,label){showToast('Exporting "'+label+'" as '+fmt.toUpperCase()+'...');}
function downloadTemplate(){
    const csv = "Name,Roll No,Department,Year,Email,Phone,Status\nSample Student,CS2024001,Computer Science,1,student@edu.in,9876543210,Active";
    const a=document.createElement('a');a.href='data:text/csv,'+encodeURIComponent(csv);a.download='student_template.csv';a.click();
}
</script>
