@extends('layouts.app')
@section('title', 'My Inquiries – SQL LMS Dealer Console')
@section('content')
@php
    $productNames = [
        1 => 'SQL Account', 2 => 'SQL Payroll', 3 => 'SQL Production', 4 => 'Mobile Sales',
        5 => 'SQL Ecommerce', 6 => 'SQL EBI Wellness POS', 7 => 'SQL X Suduai', 8 => 'SQL X-Store',
        9 => 'SQL Vision', 10 => 'SQL HRMS', 11 => 'Others',
    ];
@endphp
<div class="dashboard-content inquiries-all-page">
    <header class="inquiries-all-header">
        <div class="inquiries-all-title-row">
            <div>
                <h1 class="dashboard-title">My Inquiries</h1>
                <p class="dashboard-subtitle">All Inquiries</p>
            </div>
        </div>
    </header>

    <section class="dealer-panel dealer-inquiries-panel inquiries-all-table-panel">
        <div class="dealer-panel-header">
            <h2 class="dealer-panel-title">All Inquiries</h2>
            <button type="button" class="inquiries-btn inquiries-btn-columns">
                <span>Columns</span>
            </button>
        </div>
        <div class="dealer-table-wrapper inquiries-table-wrapper">
            <div class="inquiries-table-scroll">
                <table class="inquiries-table">
                    <thead>
                        <tr class="inquiries-table-header-row">
                        <th>
                            <span class="inquiries-col-label">INQUIRY ID</span>
                            <div class="inquiries-filter-wrap">
                                <input type="text" class="inquiries-filter-input" placeholder="Search" aria-label="Filter Inquiry ID">
                                <i class="bi bi-search inquiries-filter-icon"></i>
                            </div>
                        </th>
                        <th>
                            <span class="inquiries-col-label">DATE</span>
                            <div class="inquiries-filter-wrap">
                                <input type="text" class="inquiries-filter-input" placeholder="Search" aria-label="Filter Date">
                                <i class="bi bi-search inquiries-filter-icon"></i>
                            </div>
                        </th>
                        <th>
                            <span class="inquiries-col-label">CUSTOMER</span>
                            <div class="inquiries-filter-wrap">
                                <input type="text" class="inquiries-filter-input" placeholder="Search" aria-label="Filter Customer">
                                <i class="bi bi-search inquiries-filter-icon"></i>
                            </div>
                        </th>
                        <th>
                            <span class="inquiries-col-label">SOURCE</span>
                            <div class="inquiries-filter-wrap">
                                <input type="text" class="inquiries-filter-input" placeholder="Search" aria-label="Filter Source">
                                <i class="bi bi-search inquiries-filter-icon"></i>
                            </div>
                        </th>
                        <th>
                            <span class="inquiries-col-label">POSTCODE</span>
                            <div class="inquiries-filter-wrap">
                                <input type="text" class="inquiries-filter-input" placeholder="Search" aria-label="Filter Postcode">
                                <i class="bi bi-search inquiries-filter-icon"></i>
                            </div>
                        </th>
                        <th>
                            <span class="inquiries-col-label">CONTACT NO</span>
                            <div class="inquiries-filter-wrap">
                                <input type="text" class="inquiries-filter-input" placeholder="Search" aria-label="Filter Contact No">
                                <i class="bi bi-search inquiries-filter-icon"></i>
                            </div>
                        </th>
                        <th>
                            <span class="inquiries-col-label">BUSINESS NATURE</span>
                            <div class="inquiries-filter-wrap">
                                <input type="text" class="inquiries-filter-input" placeholder="Search" aria-label="Filter Business Nature">
                                <i class="bi bi-search inquiries-filter-icon"></i>
                            </div>
                        </th>
                        <th>
                            <span class="inquiries-col-label">USERS</span>
                            <div class="inquiries-filter-wrap">
                                <input type="text" class="inquiries-filter-input" placeholder="Search" aria-label="Filter Users">
                                <i class="bi bi-search inquiries-filter-icon"></i>
                            </div>
                        </th>
                        <th>
                            <span class="inquiries-col-label">EXISTING SW</span>
                            <div class="inquiries-filter-wrap">
                                <input type="text" class="inquiries-filter-input" placeholder="Search" aria-label="Filter Existing SW">
                                <i class="bi bi-search inquiries-filter-icon"></i>
                            </div>
                        </th>
                        <th>
                            <span class="inquiries-col-label">DEMO MODE</span>
                            <div class="inquiries-filter-wrap">
                                <input type="text" class="inquiries-filter-input" placeholder="Search" aria-label="Filter Demo Mode">
                                <i class="bi bi-search inquiries-filter-icon"></i>
                            </div>
                        </th>
                        <th>
                            <span class="inquiries-col-label">PRODUCTS</span>
                            <div class="inquiries-filter-wrap">
                                <input type="text" class="inquiries-filter-input" placeholder="Search" aria-label="Filter Products">
                                <i class="bi bi-search inquiries-filter-icon"></i>
                            </div>
                        </th>
                        <th>
                            <span class="inquiries-col-label">MESSAGE</span>
                            <div class="inquiries-filter-wrap">
                                <input type="text" class="inquiries-filter-input" placeholder="Search" aria-label="Filter Message">
                                <i class="bi bi-search inquiries-filter-icon"></i>
                            </div>
                        </th>
                        <th>
                            <span class="inquiries-col-label">REFERRAL CODE</span>
                            <div class="inquiries-filter-wrap">
                                <input type="text" class="inquiries-filter-input" placeholder="Search" aria-label="Filter Referral Code">
                                <i class="bi bi-search inquiries-filter-icon"></i>
                            </div>
                        </th>
                        <th>
                            <span class="inquiries-col-label">ASSIGN BY</span>
                            <div class="inquiries-filter-wrap">
                                <input type="text" class="inquiries-filter-input" placeholder="Search" aria-label="Filter Assign By">
                                <i class="bi bi-search inquiries-filter-icon"></i>
                            </div>
                        </th>
                        <th>
                            <span class="inquiries-col-label">STATUS</span>
                            <div class="inquiries-filter-wrap">
                                <input type="text" class="inquiries-filter-input" placeholder="Search" aria-label="Filter Status">
                                <i class="bi bi-search inquiries-filter-icon"></i>
                            </div>
                        </th>
                        <th>
                            <span class="inquiries-col-label">ACTION</span>
                            <button type="button" class="inquiries-clear-filters">Clear filters</button>
                        </th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($leads as $r)
                        @php
                            $products = [];
                            if (isset($r->PRODUCTID) && $r->PRODUCTID !== '' && $r->PRODUCTID !== null) {
                                $ids = is_numeric($r->PRODUCTID) ? [(int)$r->PRODUCTID] : array_map('intval', array_filter(explode(',', (string)$r->PRODUCTID)));
                                foreach ($ids as $id) {
                                    if ($id > 0) $products[] = $productNames[$id] ?? ('Product ' . $id);
                                }
                            }
                            if (empty($products)) $products = ['Others'];
                        @endphp
                        <tr>
                            <td><strong>#SQL-{{ $r->LEADID }}</strong></td>
                            <td>{{ $r->CREATEDAT ? date('M j, Y', strtotime($r->CREATEDAT)) : '—' }}</td>
                            <td>{{ trim(($r->COMPANYNAME ?? '') . ' ' . ($r->CONTACTNAME ?? '')) ?: '—' }}</td>
                            <td>{{ $r->CREATEDAT ? date('M j, Y', strtotime($r->CREATEDAT)) : '—' }}</td>
                            <td>{{ $r->POSTCODE ?? '—' }}</td>
                            <td>{{ $r->CONTACTNO ?? '—' }}</td>
                            <td>{{ $r->BUSINESSNATURE ?? '—' }}</td>
                            <td>{{ $r->USERCOUNT ?? '—' }}</td>
                            <td>{{ $r->EXISTINGSOFTWARE ?? '—' }}</td>
                            <td>{{ $r->DEMOMODE ?? '—' }}</td>
                            <td>
                                <div class="inquiries-product-pills">
                                    @foreach($products as $p)
                                        <span class="inquiries-product-pill">{{ $p }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td>{{ Str::limit($r->DESCRIPTION ?? '—', 20) }}</td>
                            <td>{{ $r->REFERRALCODE ?? '—' }}</td>
                            <td>{{ $r->ASSIGNED_BY_EMAIL ?? '—' }}</td>
                            <td>@php $s = trim($r->ACT_STATUS ?? ''); echo $s === '' ? '—' : (in_array(strtoupper($s), ['FOLLOWUP', 'FOLLOW UP'], true) ? 'Follow Up' : $s); @endphp</td>
                            <td>
                                @php $actStatus = strtoupper($r->ACT_STATUS ?? 'PENDING'); $isFailed = $actStatus === 'FAILED'; @endphp
                                @if ($isFailed)
                                    <button type="button" class="inquiries-view-btn" data-lead-id="{{ $r->LEADID }}" data-customer="{{ trim(($r->COMPANYNAME ?? '') . ' ' . ($r->CONTACTNAME ?? '')) ?: '—' }}">View</button>
                                @else
                                    <button type="button" class="inquiries-update-btn" data-lead-id="{{ $r->LEADID }}" data-customer="{{ trim(($r->COMPANYNAME ?? '') . ' ' . ($r->CONTACTNAME ?? '')) ?: '—' }}" data-status="{{ $actStatus }}">Update</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="inquiries-empty-row">
                            <td colspan="16" class="inquiries-empty-cell">
                                <div class="dealer-table-empty">No inquiries assigned yet.</div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="dealer-table-footer">
            <span class="dealer-table-count">Showing {{ count($leads) }} of {{ count($leads) }} inquiries</span>
            <div class="dealer-pagination">
                <button type="button" class="dealer-pagination-btn" disabled title="Previous"><i class="bi bi-chevron-left"></i></button>
                <div class="dealer-pagination-pages"><span class="dealer-pagination-btn dealer-pagination-btn--active">1</span></div>
                <button type="button" class="dealer-pagination-btn" disabled title="Next"><i class="bi bi-chevron-right"></i></button>
            </div>
        </div>
    </section>
</div>

{{-- View Failed Message Modal --}}
<div class="inquiry-modal-overlay" id="inquiryViewModal" aria-hidden="true">
    <div class="inquiry-modal inquiry-modal--view" role="dialog" aria-labelledby="inquiryViewModalTitle">
        <div class="inquiry-modal-header">
            <h2 id="inquiryViewModalTitle" class="inquiry-modal-title">Failed Inquiry</h2>
            <p class="inquiry-modal-subtitle" id="inquiryViewModalSubtitle">Inquiry ID: #SQL-0 • —</p>
            <button type="button" class="inquiry-modal-close" id="inquiryViewModalClose" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="inquiry-modal-body">
            <div class="inquiry-view-message">
                <span class="inquiry-field-label">MESSAGE</span>
                <div class="inquiry-view-message-content" id="inquiryViewMessageContent">—</div>
            </div>
        </div>
        <div class="inquiry-modal-footer">
            <button type="button" class="inquiry-btn inquiry-btn-cancel" id="inquiryViewModalCloseBtn">Close</button>
        </div>
    </div>
</div>

{{-- Update Inquiry Status Modal --}}
<div class="inquiry-modal-overlay" id="inquiryUpdateModal" aria-hidden="true">
    <div class="inquiry-modal" role="dialog" aria-labelledby="inquiryModalTitle">
        <div class="inquiry-modal-header">
            <h2 id="inquiryModalTitle" class="inquiry-modal-title">Update Inquiry Status</h2>
            <p class="inquiry-modal-subtitle" id="inquiryModalSubtitle">Inquiry ID: #SQL-0 • —</p>
            <button type="button" class="inquiry-modal-close" id="inquiryModalClose" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="inquiry-modal-body">
            <div class="inquiry-progression">
                <span class="inquiry-progression-label">INQUIRY PROGRESSION</span>
                <div class="inquiry-progression-steps" id="inquiryProgressionSteps">
                    <div class="inquiry-step inquiry-step--red" data-step="PENDING" data-color="red"><span>PENDING</span></div>
                    <div class="inquiry-connector"></div>
                    <div class="inquiry-step inquiry-step--red" data-step="FOLLOW UP" data-color="red"><span>FOLLOW UP</span></div>
                    <div class="inquiry-connector"></div>
                    <div class="inquiry-step inquiry-step--yellow" data-step="DEMO" data-color="yellow"><span>DEMO</span></div>
                    <div class="inquiry-connector"></div>
                    <div class="inquiry-step inquiry-step--yellow" data-step="CONFIRMED" data-color="yellow"><span>CONFIRMED</span></div>
                    <div class="inquiry-connector"></div>
                    <div class="inquiry-step inquiry-step--green" data-step="COMPLETED" data-color="green"><span>COMPLETED</span></div>
                    <div class="inquiry-connector"></div>
                    <div class="inquiry-step inquiry-step--green" data-step="REWARDED" data-color="green"><span>REWARDED</span></div>
                </div>
            </div>
            <div class="inquiry-followup">
                <div class="inquiry-followup-header">
                    <i class="bi bi-calendar3"></i>
                    <span>Update Details</span>
                </div>
                <div class="inquiry-followup-fields">
                    <label class="inquiry-field">
                        <span class="inquiry-field-label" id="inquiryDateLabel">FOLLOW-UP DATE</span>
                        <div class="inquiry-field-input-wrap">
                            <i class="bi bi-calendar3"></i>
                            <input type="date" class="inquiry-field-input" id="inquiryFollowupDate">
                        </div>
                    </label>
                    <label class="inquiry-field">
                        <span class="inquiry-field-label" id="inquiryTimeLabel">FOLLOW-UP TIME</span>
                        <div class="inquiry-field-input-wrap">
                            <i class="bi bi-clock"></i>
                            <input type="time" class="inquiry-field-input" id="inquiryFollowupTime">
                        </div>
                    </label>
                    <label class="inquiry-field inquiry-field-products" id="inquiryProductsField" style="display:none;">
                        <span class="inquiry-field-label">PRODUCTS <span class="inquiry-field-required">*</span></span>
                        <div class="inquiry-products-checklist" id="inquiryProductsChecklist">
                            @foreach($productNames as $id => $name)
                                <label class="inquiry-product-check">
                                    <input type="checkbox" class="inquiry-product-checkbox" name="inquiry_products[]" value="{{ $id }}" data-name="{{ $name }}">
                                    <span>{{ $name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </label>
                    <label class="inquiry-field">
                        <span class="inquiry-field-label">ATTACHMENT</span>
                        <div class="inquiry-field-input-wrap">
                            <i class="bi bi-paperclip"></i>
                            <input type="file" class="inquiry-field-input inquiry-field-file" id="inquiryAttachment" multiple>
                        </div>
                    </label>
                    <label class="inquiry-field">
                        <span class="inquiry-field-label">REMARK</span>
                        <textarea class="inquiry-field-input inquiry-field-textarea" id="inquiryRemark" placeholder="" rows="6"></textarea>
                    </label>
                </div>
            </div>
            <div class="inquiry-activity">
                <div class="inquiry-activity-header">
                    <h3 class="inquiry-activity-title">Activity</h3>
                </div>
                <div class="inquiry-activity-timeline" id="inquiryActivityTimeline">
                    <div class="inquiry-activity-item">
                        <span class="inquiry-activity-bullet"></span>
                        <div class="inquiry-activity-content">
                            <strong>System</strong> created inquiry <span class="inquiry-activity-link" id="inquiryActivityLink">#SQL-0</span> <span class="inquiry-activity-time">—</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="inquiry-modal-footer">
            <button type="button" class="inquiry-btn inquiry-btn-cancel" id="inquiryModalCancel">Cancel</button>
            <button type="button" class="inquiry-btn inquiry-btn-calendar" id="inquiryModalAddCalendar" style="display:none;"><i class="bi bi-calendar-plus"></i> Add Calendar</button>
            <button type="button" class="inquiry-btn inquiry-btn-update" id="inquiryModalUpdate"><i class="bi bi-check-lg"></i> Update Status</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    var modal = document.getElementById('inquiryUpdateModal');
    var subtitle = document.getElementById('inquiryModalSubtitle');
    var closeBtn = document.getElementById('inquiryModalClose');
    var cancelBtn = document.getElementById('inquiryModalCancel');
    var updateBtn = document.getElementById('inquiryModalUpdate');

    var activityLink = document.getElementById('inquiryActivityLink');
    var progressionSteps = document.getElementById('inquiryProgressionSteps');
    var activityTimeline = document.getElementById('inquiryActivityTimeline');

    var statusOrder = ['PENDING', 'FOLLOW UP', 'DEMO', 'CONFIRMED', 'COMPLETED', 'REWARDED'];
    var remarkPlaceholders = {
        'PENDING': 'Add specific notes about this inquiry...',
        'FOLLOW UP': 'Add specific notes about this follow-up...',
        'DEMO': 'Add specific notes about this demo...',
        'CONFIRMED': 'Add specific notes about this confirmation...',
        'COMPLETED': 'Add specific notes about this completion...',
        'REWARDED': 'Add specific notes about this reward...'
    };
    var dateTimeLabels = {
        'PENDING': { date: 'FOLLOW-UP DATE', time: 'FOLLOW-UP TIME' },
        'FOLLOW UP': { date: 'FOLLOW-UP DATE', time: 'FOLLOW-UP TIME' },
        'DEMO': { date: 'DEMO DATE', time: 'DEMO TIME' },
        'CONFIRMED': { date: 'CONFIRMED DATE', time: 'CONFIRMED TIME' },
        'COMPLETED': { date: 'COMPLETED DATE', time: 'COMPLETED TIME' },
        'REWARDED': { date: 'REWARD DATE', time: 'REWARD TIME' }
    };
    var statusMap = {
        'PENDING': 'PENDING', 'FOLLOW UP': 'FOLLOW UP', 'FOLLOWUP': 'FOLLOW UP',
        'DEMO': 'DEMO', 'CONFIRMED': 'CONFIRMED', 'CASE CONFIRMED': 'CONFIRMED',
        'COMPLETED': 'COMPLETED', 'CASE COMPLETED': 'COMPLETED',
        'REWARD': 'REWARDED', 'REWARDED': 'REWARDED', 'REWARD DISTRIBUTED': 'REWARDED'
    };

    var currentLeadId = '';
    var currentCustomer = '';
    var currentStatusIdx = 0;
    var selectedStatusIdx = 0;
    var viewMode = false;
    var cachedActivities = [];

    function setProgression(currentStatus) {
        var normalized = statusMap[currentStatus] || 'PENDING';
        var idx = statusOrder.indexOf(normalized);
        if (idx < 0) idx = 0;
        currentStatusIdx = idx;
        selectedStatusIdx = Math.min(idx + 1, statusOrder.length - 1);
        if (progressionSteps) {
            var steps = progressionSteps.querySelectorAll('.inquiry-step');
            var showDone = function(i) { return i <= idx; };
            steps.forEach(function(step, i) {
                step.classList.remove('inquiry-step--done', 'inquiry-step--active', 'inquiry-step--selected', 'inquiry-step--clickable', 'inquiry-step--no-click', 'inquiry-step--viewable');
                step.innerHTML = '<span>' + step.dataset.step + '</span>';
                if (showDone(i)) {
                    step.classList.add('inquiry-step--done', 'inquiry-step--viewable');
                    step.innerHTML = '<i class="bi bi-check"></i><span>' + step.dataset.step + '</span>';
                } else if (i === selectedStatusIdx) {
                    step.classList.add('inquiry-step--active', 'inquiry-step--selected');
                } else if (i === 0) {
                    step.classList.add('inquiry-step--no-click');
                } else {
                    step.classList.add('inquiry-step--clickable');
                }
            });
        }
        var remarkEl = document.getElementById('inquiryRemark');
        if (remarkEl) remarkEl.placeholder = remarkPlaceholders[statusOrder[selectedStatusIdx]] || remarkPlaceholders['PENDING'];
        setDateTimeLabels(statusOrder[selectedStatusIdx]);
        toggleAddCalendarButton();
        toggleProductChecklist();
        toggleUpdateButton();
    }

    function setRemarkPlaceholder(status) {
        var remarkEl = document.getElementById('inquiryRemark');
        if (remarkEl) remarkEl.placeholder = remarkPlaceholders[status] || remarkPlaceholders['PENDING'];
    }

    function setDateTimeLabels(status) {
        var labels = dateTimeLabels[status] || dateTimeLabels['FOLLOW UP'];
        var dateLabel = document.getElementById('inquiryDateLabel');
        var timeLabel = document.getElementById('inquiryTimeLabel');
        if (dateLabel) dateLabel.textContent = labels.date;
        if (timeLabel) timeLabel.textContent = labels.time;
    }

    function toggleAddCalendarButton() {
        var btn = document.getElementById('inquiryModalAddCalendar');
        if (btn) btn.style.display = statusOrder[selectedStatusIdx] === 'DEMO' ? '' : 'none';
    }

    function toggleProductChecklist() {
        var field = document.getElementById('inquiryProductsField');
        var isCompleted = statusOrder[selectedStatusIdx] === 'COMPLETED' && !viewMode;
        if (field) {
            field.style.display = isCompleted ? '' : 'none';
            if (!isCompleted) {
                var boxes = field.querySelectorAll('.inquiry-product-checkbox');
                boxes.forEach(function(b) { b.checked = false; });
            }
        }
    }

    function toggleUpdateButton() {
        var isRewarded = currentStatusIdx === statusOrder.length - 1;
        var disable = isRewarded || viewMode;
        updateBtn.disabled = disable;
        updateBtn.classList.toggle('inquiry-btn-update--disabled', disable);
    }

    function statusMatches(orderName, activityStatus) {
        var a = (orderName || '').toUpperCase().replace(/\s+/g, '');
        var b = (activityStatus || '').toUpperCase().replace(/\s+/g, '').replace('REWARDDISTRIBUTED', 'REWARDED');
        if (a === 'REWARDED') return b === 'REWARDED' || b === 'REWARDDISTRIBUTED';
        return a === b;
    }

    function findActivityForStatus(statusOrderName) {
        for (var j = 0; j < cachedActivities.length; j++) {
            if (cachedActivities[j].type === 'activity' && statusMatches(statusOrderName, cachedActivities[j].status)) {
                return cachedActivities[j];
            }
        }
        return null;
    }

    function populateFormFromActivity(activity) {
        var dateEl = document.getElementById('inquiryFollowupDate');
        var timeEl = document.getElementById('inquiryFollowupTime');
        var remarkEl = document.getElementById('inquiryRemark');
        if (!activity || !activity.created_at) {
            if (dateEl) dateEl.value = '';
            if (timeEl) timeEl.value = '';
            if (remarkEl) remarkEl.value = '';
            return;
        }
        var d = new Date(activity.created_at);
        if (dateEl) dateEl.value = isNaN(d.getTime()) ? '' : d.toISOString().slice(0, 10);
        if (timeEl) timeEl.value = isNaN(d.getTime()) ? '' : String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0');
        if (remarkEl) remarkEl.value = activity.description || '';
    }

    function setFieldsReadOnly(readOnly) {
        var dateEl = document.getElementById('inquiryFollowupDate');
        var timeEl = document.getElementById('inquiryFollowupTime');
        var remarkEl = document.getElementById('inquiryRemark');
        var fileEl = document.getElementById('inquiryAttachment');
        var productBoxes = document.querySelectorAll('.inquiry-product-checkbox');
        if (dateEl) dateEl.readOnly = readOnly;
        if (timeEl) timeEl.readOnly = readOnly;
        if (remarkEl) remarkEl.readOnly = readOnly;
        if (fileEl) fileEl.disabled = readOnly;
        productBoxes.forEach(function(b) { b.disabled = readOnly; });
    }

    function formatActivityTime(isoStr) {
        if (!isoStr) return '—';
        var d = new Date(isoStr);
        if (isNaN(d.getTime())) return isoStr;
        var now = new Date();
        var diff = Math.floor((now - d) / 1000);
        if (diff < 60) return 'just now';
        if (diff < 3600) return Math.floor(diff / 60) + 'm ago';
        if (diff < 86400) return Math.floor(diff / 3600) + 'h ago';
        if (diff < 604800) return Math.floor(diff / 86400) + 'd ago';
        return d.toLocaleDateString() + ' ' + d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    function renderActivity(activities) {
        if (!activityTimeline) return;
        activityTimeline.innerHTML = '';
        if (!activities || activities.length === 0) {
            activityTimeline.innerHTML = '<div class="inquiry-activity-item"><span class="inquiry-activity-bullet"></span><div class="inquiry-activity-content">No activity yet.</div></div>';
            return;
        }
        activities.forEach(function(a) {
            var item = document.createElement('div');
            item.className = 'inquiry-activity-item';
            var user = (a.user || 'System').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            var timeStr = formatActivityTime(a.created_at);
            var html = '<span class="inquiry-activity-bullet"></span><div class="inquiry-activity-content">';
            if (a.type === 'created') {
                html += '<strong>' + user + '</strong> created inquiry <span class="inquiry-activity-link">#SQL-' + currentLeadId + '</span>';
            } else {
                var subj = (a.subject || '').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                var desc = (a.description || '').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                var status = (a.status || '').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                html += '<strong>' + user + '</strong> ' + (subj ? subj + ' ' : '');
                if (status) html += 'changed status to <span class="inquiry-activity-status">' + status + '</span> ';
                if (desc) html += '<span class="inquiry-activity-desc">' + desc + '</span> ';
            }
            html += '<span class="inquiry-activity-time">' + timeStr + '</span></div>';
            item.innerHTML = html;
            activityTimeline.appendChild(item);
        });
    }

    function loadActivity(leadId) {
        var url = '{{ route("dealer.inquiries.activity", ["leadId" => "__ID__"]) }}'.replace('__ID__', leadId);
        fetch(url, { headers: { 'Accept': 'application/json' } })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                cachedActivities = data.activities || [];
                renderActivity(cachedActivities);
                var details = data.last_reward_details;
                if (details && currentStatusIdx === statusOrder.length - 1) {
                    var dateEl = document.getElementById('inquiryFollowupDate');
                    var timeEl = document.getElementById('inquiryFollowupTime');
                    var remarkEl = document.getElementById('inquiryRemark');
                    if (dateEl && details.date) dateEl.value = details.date;
                    if (timeEl && details.time) timeEl.value = details.time;
                    if (remarkEl && details.description) remarkEl.value = details.description;
                    setFieldsReadOnly(true);
                }
            })
            .catch(function() {
                renderActivity([]);
            });
    }

    function openModal(leadId, customer, status) {
        currentLeadId = leadId;
        currentCustomer = customer || '—';
        viewMode = false;
        subtitle.textContent = 'Inquiry ID: #SQL-' + leadId + ' • ' + currentCustomer;
        if (activityLink) activityLink.textContent = '#SQL-' + leadId;
        setProgression(status || 'PENDING');
        var remarkEl = document.getElementById('inquiryRemark');
        var dateEl = document.getElementById('inquiryFollowupDate');
        var timeEl = document.getElementById('inquiryFollowupTime');
        if (remarkEl) remarkEl.value = '';
        if (dateEl) dateEl.value = '';
        if (timeEl) timeEl.value = '';
        var productBoxes = document.querySelectorAll('.inquiry-product-checkbox');
        if (productBoxes.length) productBoxes.forEach(function(b) { b.checked = false; });
        setFieldsReadOnly(false);
        loadActivity(leadId);
        modal.setAttribute('aria-hidden', 'false');
        modal.classList.add('inquiry-modal-open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.setAttribute('aria-hidden', 'true');
        modal.classList.remove('inquiry-modal-open');
        document.body.style.overflow = '';
    }

    if (progressionSteps) {
        progressionSteps.addEventListener('click', function(e) {
            var step = e.target.closest('.inquiry-step');
            if (!step) return;
            if (step.classList.contains('inquiry-step--no-click')) return;
            var stepIdx = statusOrder.indexOf(step.dataset.step);
            if (stepIdx < 0) return;
            var isDoneStep = stepIdx <= currentStatusIdx;
            var isFutureStep = step.classList.contains('inquiry-step--clickable');
            if (!isDoneStep && !isFutureStep) return;
            selectedStatusIdx = stepIdx;
            if (isDoneStep) {
                viewMode = true;
                var act = findActivityForStatus(statusOrder[stepIdx]);
                populateFormFromActivity(act);
                setFieldsReadOnly(true);
                setDateTimeLabels(statusOrder[stepIdx]);
            } else {
                viewMode = false;
                var remarkEl = document.getElementById('inquiryRemark');
                var dateEl = document.getElementById('inquiryFollowupDate');
                var timeEl = document.getElementById('inquiryFollowupTime');
                if (remarkEl) remarkEl.value = '';
                if (dateEl) dateEl.value = '';
                if (timeEl) timeEl.value = '';
                setFieldsReadOnly(false);
                setRemarkPlaceholder(statusOrder[stepIdx]);
                setDateTimeLabels(statusOrder[stepIdx]);
            }
            progressionSteps.querySelectorAll('.inquiry-step').forEach(function(s, i) {
                s.classList.remove('inquiry-step--active', 'inquiry-step--selected', 'inquiry-step--clickable', 'inquiry-step--no-click', 'inquiry-step--viewable');
                var stepName = s.dataset.step;
                var sIsDone = i <= currentStatusIdx;
                if (sIsDone) {
                    s.classList.add('inquiry-step--done', 'inquiry-step--viewable');
                    if (i === selectedStatusIdx && viewMode) s.classList.add('inquiry-step--selected');
                    s.innerHTML = '<i class="bi bi-check"></i><span>' + stepName + '</span>';
                } else if (i === selectedStatusIdx) {
                    s.classList.add('inquiry-step--active', 'inquiry-step--selected');
                    s.innerHTML = '<span>' + stepName + '</span>';
                } else if (i === 0) {
                    s.classList.add('inquiry-step--no-click');
                    s.innerHTML = '<span>' + stepName + '</span>';
                } else {
                    s.classList.add('inquiry-step--clickable');
                    s.innerHTML = '<span>' + stepName + '</span>';
                }
            });
            toggleAddCalendarButton();
            toggleProductChecklist();
            toggleUpdateButton();
        });
    }

    document.querySelectorAll('.inquiries-update-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            openModal(btn.dataset.leadId, btn.dataset.customer, btn.dataset.status);
        });
    });

    var viewModal = document.getElementById('inquiryViewModal');
    var viewSubtitle = document.getElementById('inquiryViewModalSubtitle');
    var viewContent = document.getElementById('inquiryViewMessageContent');
    var viewCloseBtn = document.getElementById('inquiryViewModalClose');
    var viewCloseBtnFooter = document.getElementById('inquiryViewModalCloseBtn');
    document.querySelectorAll('.inquiries-view-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var leadId = btn.dataset.leadId;
            var customer = btn.dataset.customer || '—';
            if (viewSubtitle) viewSubtitle.textContent = 'Inquiry ID: #SQL-' + leadId + ' • ' + customer;
            if (viewContent) viewContent.textContent = 'Loading...';
            viewModal.setAttribute('aria-hidden', 'false');
            viewModal.classList.add('inquiry-modal-open');
            document.body.style.overflow = 'hidden';
            fetch('{{ url("/dealer/inquiries") }}/' + leadId + '/failed-description', {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (viewContent) viewContent.textContent = (data.description || '').trim() || '—';
            })
            .catch(function() {
                if (viewContent) viewContent.textContent = '—';
            });
        });
    });
    function closeViewModal() {
        viewModal.setAttribute('aria-hidden', 'true');
        viewModal.classList.remove('inquiry-modal-open');
        document.body.style.overflow = '';
    }
    if (viewCloseBtn) viewCloseBtn.addEventListener('click', closeViewModal);
    if (viewCloseBtnFooter) viewCloseBtnFooter.addEventListener('click', closeViewModal);
    viewModal.addEventListener('click', function(e) {
        if (e.target === viewModal) closeViewModal();
    });

    [closeBtn, cancelBtn].forEach(function(btn) {
        if (btn) btn.addEventListener('click', closeModal);
    });

    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (viewModal && viewModal.classList.contains('inquiry-modal-open')) closeViewModal();
            else if (modal.classList.contains('inquiry-modal-open')) closeModal();
        }
    });

    var addCalendarBtn = document.getElementById('inquiryModalAddCalendar');
    if (addCalendarBtn) {
        addCalendarBtn.addEventListener('click', function() {
            var dateEl = document.getElementById('inquiryFollowupDate');
            var timeEl = document.getElementById('inquiryFollowupTime');
            var remarkEl = document.getElementById('inquiryRemark');
            var dateStr = dateEl ? dateEl.value : '';
            var timeStr = timeEl ? timeEl.value : '';
            var remark = remarkEl ? remarkEl.value.trim() : '';
            var title = 'Demo: #SQL-' + currentLeadId + ' - ' + currentCustomer;
            var details = 'Inquiry #SQL-' + currentLeadId + '\nCustomer: ' + currentCustomer + (remark ? '\n\n' + remark : '');
            var startDate, endDate;
            if (dateStr) {
                var d = new Date(dateStr + (timeStr ? 'T' + timeStr : 'T09:00:00'));
                if (isNaN(d.getTime())) d = new Date();
                startDate = d;
                endDate = new Date(d.getTime() + 60 * 60 * 1000);
            } else {
                startDate = new Date();
                endDate = new Date(startDate.getTime() + 60 * 60 * 1000);
            }
            var fmt = function(d) {
                var y = d.getFullYear(), m = String(d.getMonth() + 1).padStart(2, '0'), day = String(d.getDate()).padStart(2, '0');
                var h = String(d.getHours()).padStart(2, '0'), min = String(d.getMinutes()).padStart(2, '0'), s = String(d.getSeconds()).padStart(2, '0');
                return y + m + day + 'T' + h + min + s;
            };
            var url = 'https://calendar.google.com/calendar/render?action=TEMPLATE&text=' + encodeURIComponent(title) + '&dates=' + fmt(startDate) + '/' + fmt(endDate) + '&details=' + encodeURIComponent(details);
            window.open(url, '_blank', 'noopener,noreferrer');
        });
    }

    updateBtn.addEventListener('click', function() {
        if (this.disabled || selectedStatusIdx <= currentStatusIdx) return;
        var toStatus = statusOrder[selectedStatusIdx];
        if (toStatus === 'DEMO' && currentStatusIdx < 1) {
            alert('You must complete the follow-up (status: FOLLOW UP) before updating to DEMO. Please update the status to FOLLOW UP first.');
            return;
        }
        if (toStatus === 'REWARDED' && currentStatusIdx < 4) {
            alert('You must complete the inquiry (status: COMPLETED) before updating to REWARDED. Please update the status to COMPLETED first.');
            return;
        }
        if (toStatus === 'COMPLETED') {
            var checked = document.querySelectorAll('.inquiry-product-checkbox:checked');
            if (!checked.length) {
                alert('Please select at least one product for COMPLETED status.');
                return;
            }
        }
        var leadId = currentLeadId;
        var remarkEl = document.getElementById('inquiryRemark');
        var remark = remarkEl ? remarkEl.value.trim() : '';
        var products = [];
        if (toStatus === 'COMPLETED') {
            document.querySelectorAll('.inquiry-product-checkbox:checked').forEach(function(cb) {
                products.push({ id: cb.value, name: cb.dataset.name });
            });
        }
        var updateUrl = '{{ route("dealer.inquiries.update-status") }}';
        var csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';
        updateBtn.disabled = true;
        fetch(updateUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ lead_id: leadId, status: toStatus, remark: remark, products: products })
        })
        .then(function(r) { return r.json().then(function(d) { return { ok: r.ok, data: d }; }); })
        .then(function(res) {
            updateBtn.disabled = false;
            if (res.ok && res.data.success) {
                closeModal();
                window.location.reload();
            } else {
                alert(res.data.message || 'Update failed');
            }
        })
        .catch(function() {
            updateBtn.disabled = false;
            alert('Update failed. Please try again.');
        });
    });
})();
</script>
@endpush
@endsection
