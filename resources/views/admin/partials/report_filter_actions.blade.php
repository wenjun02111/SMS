@php
    $filterActionsWrapperClass = trim((string) ($wrapperClass ?? ''));
    $filterActionsApplyClass = trim((string) ($applyClass ?? ''));
    $filterActionsClearClass = trim((string) ($clearClass ?? ''));
    $filterActionsExportClass = trim((string) ($exportClass ?? ''));
    $filterActionsApplyLabel = $applyLabel ?? 'Apply';
    $filterActionsExportLabel = $exportLabel ?? 'Export PDF';
    $filterActionsClearLabel = $clearLabel ?? 'Clear';
    $filterActionsApplyEnabled = (bool) ($showApply ?? true);
    $filterActionsExportEnabled = (bool) ($showExport ?? false);
    $filterActionsClearEnabled = (bool) ($showClear ?? true);
    $filterActionsExportTitle = trim((string) ($exportTitle ?? 'Report'));
    $filterActionsExportTarget = trim((string) ($exportTarget ?? ''));
    $filterActionsClearUrl = $clearUrl ?? '#';
@endphp

<div class="{{ $filterActionsWrapperClass }}">
    @if ($filterActionsApplyEnabled)
        <button type="submit" class="{{ $filterActionsApplyClass }}">{{ $filterActionsApplyLabel }}</button>
    @endif
    @if ($filterActionsExportEnabled)
        <button
            type="button"
            class="{{ $filterActionsExportClass }}"
            data-export-report-pdf
            data-export-title="{{ $filterActionsExportTitle }}"
            @if ($filterActionsExportTarget !== '') data-export-target="{{ $filterActionsExportTarget }}" @endif
        >{{ $filterActionsExportLabel }}</button>
    @endif
    @if ($filterActionsClearEnabled)
        <a href="{{ $filterActionsClearUrl }}" class="{{ $filterActionsClearClass }}">{{ $filterActionsClearLabel }}</a>
    @endif
</div>
