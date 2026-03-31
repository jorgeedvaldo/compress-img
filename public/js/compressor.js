/**
 * CompressImg - Client-Side Image Compressor
 * Supports: JPG, PNG, GIF, WebP, SVG, BMP, TIFF, ICO
 * Levels: Alta (80%), Média (50%), Baixa (20%)
 */
(function () {
    'use strict';

    // Localized strings (set by Blade template)
    var LANG = window.COMPRESS_LANG || {};

    // Quality mappings
    var QUALITY_MAP = {
        alta: 0.80,
        media: 0.50,
        baixa: 0.20
    };

    // State
    var selectedFiles = [];
    var compressedFiles = [];
    var currentQuality = 'alta';

    // DOM refs
    var uploadArea = document.getElementById('uploadArea');
    var fileInput = document.getElementById('fileInput');
    var qualitySection = document.getElementById('qualitySection');
    var progressArea = document.getElementById('progressArea');
    var progressBar = document.getElementById('progressBar');
    var resultsArea = document.getElementById('resultsArea');
    var resultsBody = document.getElementById('resultsBody');
    var resultsSummary = document.getElementById('resultsSummary');
    var btnCompress = document.getElementById('btnCompress');
    var btnClear = document.getElementById('btnClear');
    var btnDownloadAll = document.getElementById('btnDownloadAll');

    if (!uploadArea) return;

    // ---- Upload Area Events ----
    uploadArea.addEventListener('click', function () {
        fileInput.click();
    });

    uploadArea.addEventListener('dragover', function (e) {
        e.preventDefault();
        e.stopPropagation();
        uploadArea.classList.add('drag-over');
    });

    uploadArea.addEventListener('dragleave', function (e) {
        e.preventDefault();
        e.stopPropagation();
        uploadArea.classList.remove('drag-over');
    });

    uploadArea.addEventListener('drop', function (e) {
        e.preventDefault();
        e.stopPropagation();
        uploadArea.classList.remove('drag-over');
        var files = e.dataTransfer.files;
        handleFiles(files);
    });

    fileInput.addEventListener('change', function () {
        handleFiles(this.files);
    });

    // ---- Quality Radio Cards ----
    var radioCards = document.querySelectorAll('.radio-card');
    for (var i = 0; i < radioCards.length; i++) {
        (function (card) {
            card.addEventListener('click', function () {
                for (var j = 0; j < radioCards.length; j++) {
                    radioCards[j].classList.remove('active');
                    radioCards[j].querySelector('input[type="radio"]').checked = false;
                }
                card.classList.add('active');
                card.querySelector('input[type="radio"]').checked = true;
                currentQuality = card.getAttribute('data-quality');
            });
        })(radioCards[i]);
    }

    // ---- Compress Button ----
    btnCompress.addEventListener('click', function () {
        compressAllFiles();
    });

    // ---- Clear Button ----
    btnClear.addEventListener('click', function () {
        resetAll();
    });

    // ---- Download All ----
    btnDownloadAll.addEventListener('click', function () {
        downloadAllFiles();
    });

    // ---- Handle Files ----
    function handleFiles(fileList) {
        selectedFiles = [];
        for (var i = 0; i < fileList.length; i++) {
            if (fileList[i].type.match(/image\//)) {
                selectedFiles.push(fileList[i]);
            }
        }
        if (selectedFiles.length > 0) {
            qualitySection.style.display = 'block';
            resultsArea.style.display = 'none';
            progressArea.style.display = 'none';

            // Update upload area text
            uploadArea.innerHTML =
                '<div class="upload-icon"><i class="fa fa-check-circle" style="color:#27ae60;"></i></div>' +
                '<h3>' + selectedFiles.length + ' ' + (LANG.images_selected || 'imagem(ns) selecionada(s)') + '</h3>' +
                '<p>' + (LANG.click_select_other || 'Clique para selecionar outras imagens') + '</p>' +
                '<input type="file" id="fileInput" multiple accept="image/*" class="hidden">';

            // Re-bind file input
            var newInput = document.getElementById('fileInput');
            newInput.addEventListener('change', function () {
                handleFiles(this.files);
            });
        }
    }

    // ---- Compress All ----
    function compressAllFiles() {
        if (selectedFiles.length === 0) return;

        compressedFiles = [];
        progressArea.style.display = 'block';
        resultsArea.style.display = 'none';
        btnCompress.disabled = true;

        var quality = QUALITY_MAP[currentQuality];
        var total = selectedFiles.length;
        var done = 0;

        updateProgress(0);

        function processNext(index) {
            if (index >= total) {
                showResults();
                return;
            }

            compressFile(selectedFiles[index], quality, function (result) {
                compressedFiles.push(result);
                done++;
                updateProgress(Math.round((done / total) * 100));
                processNext(index + 1);
            });
        }

        processNext(0);
    }

    // ---- Compress Single File ----
    function compressFile(file, quality, callback) {
        var originalSize = file.size;
        var fileName = file.name;
        var fileType = file.type;

        // SVG special handling - minify text
        if (fileType === 'image/svg+xml') {
            var reader = new FileReader();
            reader.onload = function (e) {
                var svgText = e.target.result;
                var minified = minifySVG(svgText);
                var blob = new Blob([minified], { type: 'image/svg+xml' });
                var url = URL.createObjectURL(blob);
                callback({
                    name: fileName,
                    originalSize: originalSize,
                    compressedSize: blob.size,
                    url: url,
                    blob: blob,
                    type: fileType,
                    previewUrl: url
                });
            };
            reader.readAsText(file);
            return;
        }

        // For raster images, use Canvas
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = new Image();
            img.onload = function () {
                var canvas = document.createElement('canvas');
                var ctx = canvas.getContext('2d');

                // Calculate dimensions based on quality
                var scale = 1;
                if (quality < 0.5) {
                    scale = 0.75;
                } else if (quality < 0.3) {
                    scale = 0.5;
                }

                canvas.width = Math.round(img.width * scale);
                canvas.height = Math.round(img.height * scale);

                // Draw with smoothing
                ctx.imageSmoothingEnabled = true;
                ctx.imageSmoothingQuality = 'high';
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                // Determine output type
                var outputType = 'image/jpeg';
                var ext = '.jpg';

                if (fileType === 'image/png') {
                    // For PNG, we keep as PNG but reduce via canvas
                    // For lower quality, convert to JPEG for better compression
                    if (quality < 0.5) {
                        outputType = 'image/jpeg';
                        ext = '.jpg';
                    } else {
                        outputType = 'image/png';
                        ext = '.png';
                    }
                } else if (fileType === 'image/webp') {
                    outputType = 'image/webp';
                    ext = '.webp';
                } else if (fileType === 'image/gif') {
                    // GIF gets converted to PNG/JPEG (canvas doesn't support animated GIF)
                    outputType = 'image/jpeg';
                    ext = '.jpg';
                } else {
                    outputType = 'image/jpeg';
                    ext = '.jpg';
                }

                canvas.toBlob(function (blob) {
                    if (!blob) {
                        // Fallback
                        callback({
                            name: fileName,
                            originalSize: originalSize,
                            compressedSize: originalSize,
                            url: e.target.result,
                            blob: file,
                            type: fileType,
                            previewUrl: e.target.result
                        });
                        return;
                    }

                    var compressedUrl = URL.createObjectURL(blob);

                    // If compressed is bigger, use original
                    if (blob.size >= originalSize) {
                        callback({
                            name: fileName,
                            originalSize: originalSize,
                            compressedSize: originalSize,
                            url: URL.createObjectURL(file),
                            blob: file,
                            type: fileType,
                            previewUrl: e.target.result
                        });
                    } else {
                        // Build output name
                        var baseName = fileName.replace(/\.[^.]+$/, '');
                        var outputName = baseName + '-compressed' + ext;

                        callback({
                            name: outputName,
                            originalSize: originalSize,
                            compressedSize: blob.size,
                            url: compressedUrl,
                            blob: blob,
                            type: outputType,
                            previewUrl: e.target.result
                        });
                    }
                }, outputType, quality);
            };

            img.onerror = function () {
                callback({
                    name: fileName,
                    originalSize: originalSize,
                    compressedSize: originalSize,
                    url: e.target.result,
                    blob: file,
                    type: fileType,
                    previewUrl: e.target.result
                });
            };

            img.src = e.target.result;
        };

        reader.readAsDataURL(file);
    }

    // ---- SVG Minifier ----
    function minifySVG(svgString) {
        // Remove comments
        svgString = svgString.replace(/<!--[\s\S]*?-->/g, '');
        // Remove unnecessary whitespace
        svgString = svgString.replace(/\s+/g, ' ');
        // Remove whitespace between tags
        svgString = svgString.replace(/>\s+</g, '><');
        // Remove leading/trailing whitespace
        svgString = svgString.trim();
        return svgString;
    }

    // ---- Update Progress ----
    function updateProgress(pct) {
        progressBar.style.width = pct + '%';
        progressBar.textContent = pct + '%';
    }

    // ---- Show Results ----
    function showResults() {
        progressArea.style.display = 'none';
        resultsArea.style.display = 'block';
        btnCompress.disabled = false;

        // Calculate totals
        var totalOriginal = 0;
        var totalCompressed = 0;

        resultsBody.innerHTML = '';

        for (var i = 0; i < compressedFiles.length; i++) {
            var f = compressedFiles[i];
            totalOriginal += f.originalSize;
            totalCompressed += f.compressedSize;

            var reduction = Math.round((1 - f.compressedSize / f.originalSize) * 100);
            if (reduction < 0) reduction = 0;

            var badgeClass = 'reduction-low';
            if (reduction >= 50) badgeClass = 'reduction-great';
            else if (reduction >= 20) badgeClass = 'reduction-good';

            var row = document.createElement('tr');
            row.innerHTML =
                '<td><img src="' + f.previewUrl + '" alt="preview"></td>' +
                '<td>' + escapeHtml(f.name) + '</td>' +
                '<td>' + formatSize(f.originalSize) + '</td>' +
                '<td>' + formatSize(f.compressedSize) + '</td>' +
                '<td><span class="reduction-badge ' + badgeClass + '">-' + reduction + '%</span></td>' +
                '<td><a href="' + f.url + '" download="' + escapeHtml(f.name) + '" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> ' + (LANG.btn_download || 'Baixar') + '</a></td>';

            resultsBody.appendChild(row);
        }

        // Summary
        var totalReduction = Math.round((1 - totalCompressed / totalOriginal) * 100);
        if (totalReduction < 0) totalReduction = 0;

        resultsSummary.innerHTML =
            '<i class="fa fa-pie-chart"></i> ' +
            '<strong>' + compressedFiles.length + '</strong> ' + (LANG.images_compressed || 'imagem(ns) comprimida(s)') + ' | ' +
            'Original: <strong>' + formatSize(totalOriginal) + '</strong> → ' +
            'Compressed: <strong>' + formatSize(totalCompressed) + '</strong> | ' +
            (LANG.total_savings || 'Economia total') + ': <strong>' + totalReduction + '%</strong> (' + formatSize(totalOriginal - totalCompressed) + ')';
    }

    // ---- Download All ----
    function downloadAllFiles() {
        for (var i = 0; i < compressedFiles.length; i++) {
            var link = document.createElement('a');
            link.href = compressedFiles[i].url;
            link.download = compressedFiles[i].name;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }

    // ---- Reset ----
    function resetAll() {
        selectedFiles = [];
        compressedFiles = [];
        qualitySection.style.display = 'none';
        progressArea.style.display = 'none';
        resultsArea.style.display = 'none';

        uploadArea.innerHTML =
            '<div class="upload-icon"><i class="fa fa-cloud-upload"></i></div>' +
            '<h3>' + (LANG.upload_title || 'Arraste e solte suas imagens aqui') + '</h3>' +
            '<p>' + (LANG.upload_subtitle || 'ou clique para selecionar arquivos') + '</p>' +
            '<p class="text-muted"><small>' + (LANG.upload_formats || 'Suporta: JPG, PNG, GIF, WebP, SVG, BMP, TIFF, ICO &bull; Máximo: 50MB por imagem') + '</small></p>' +
            '<input type="file" id="fileInput" multiple accept="image/*" class="hidden">';

        var newInput = document.getElementById('fileInput');
        newInput.addEventListener('change', function () {
            handleFiles(this.files);
        });
    }

    // ---- Helpers ----
    function formatSize(bytes) {
        if (bytes === 0) return '0 B';
        var sizes = ['B', 'KB', 'MB', 'GB'];
        var i = Math.floor(Math.log(bytes) / Math.log(1024));
        return (bytes / Math.pow(1024, i)).toFixed(i === 0 ? 0 : 2) + ' ' + sizes[i];
    }

    function escapeHtml(str) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    }

})();
