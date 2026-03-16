@extends('layouts.app')
@section('title', 'Rewards – Admin')
@section('content')
<div class="inquiries-page-wrap">
<div class="inquiries-mgmt-top-row" style="margin-bottom: 16px;">
    <section class="inquiries-mgmt-summary">
        <div class="inquiries-summary-card">
            <div class="inquiries-summary-icon"><i class="bi bi-check2-circle"></i></div>
            <div class="inquiries-summary-label">PENDING REWARD</div>
            <div class="inquiries-summary-value-row">
                <span class="inquiries-summary-value">{{ number_format($totalCompletedLeads ?? 0) }}</span>
            </div>
            <div class="inquiries-summary-note">Pending Referral Payout</div>
        </div>
    </section>
    <section class="inquiries-mgmt-search">
        <div class="inquiries-search-row">
            <div class="inquiries-search-wrap">
                <span class="inquiries-search-icon"><i class="bi bi-search"></i></span>
                <input type="text" class="inquiries-search-input" id="payoutSearchInput" placeholder="Search table..." autocomplete="off">
                <button type="button" class="inquiries-search-btn" id="payoutSearchBtn">Search</button>
            </div>
            <button type="button" class="inquiries-btn inquiries-btn-secondary inquiries-search-clear-btn" id="payoutClearSearchBtn" title="Clear search">Clear</button>
        </div>
    </section>
</div>

<div class="inquiries-tabs">
    <button type="button" class="inquiries-tab active" data-tab="completed" aria-selected="true">Completed</button>
    <button type="button" class="inquiries-tab" data-tab="rewarded" aria-selected="false">Rewarded</button>
</div>

<div class="inquiries-tab-panel active" id="completedPanel" role="tabpanel">
<section class="inquiries-mgmt-panel">
    <div class="inquiries-panel-header">
        <div class="inquiries-panel-title-wrap">
            <i class="bi bi-check2-circle inquiries-panel-icon"></i>
            <h2 class="inquiries-panel-title">Completed</h2>
        </div>
        <div class="inquiries-panel-actions">
            <button type="button" class="inquiries-btn inquiries-btn-secondary inquiries-sync-btn" data-sync-type="assigned" data-sync-url="{{ route('admin.inquiries.sync') }}">
                <i class="bi bi-arrow-repeat inquiries-sync-icon"></i>
                <span class="inquiries-sync-label">Sync</span>
            </button>
            <div class="inquiries-columns-dropdown">
                <button type="button" class="inquiries-btn inquiries-btn-secondary" id="completedColumnsBtn" aria-haspopup="true" aria-expanded="false">Columns</button>
                <div class="inquiries-columns-menu" id="completedColumnsMenu" hidden>
                    <div class="inquiries-columns-menu-title">Show columns</div>
                    <label class="inquiries-columns-check"><input type="checkbox" data-col="inquiryid"> INQUIRY ID</label>
                    <label class="inquiries-columns-check"><input type="checkbox" data-col="date"> INQUIRY DATE</label>
                    <label class="inquiries-columns-check"><input type="checkbox" data-col="customername"> CUSTOMER NAME</label>
                    <label class="inquiries-columns-check"><input type="checkbox" data-col="source"> SOURCE</label>
                    <label class="inquiries-columns-check"><input type="checkbox" data-col="postcode"> POSTCODE</label>
                    <label class="inquiries-columns-check"><input type="checkbox" data-col="city"> CITY</label>
                    <label class="inquiries-columns-check"><input type="checkbox" data-col="address"> ADDRESS</label>
                    <label class="inquiries-columns-check"><input type="checkbox" data-col="contactno"> CONTACT NO</label>
                    <label class="inquiries-columns-check"><input type="checkbox" data-col="businessnature"> BUSINESS NATURE</label>
                    <label class="inquiries-columns-check"><input type="checkbox" data-col="users"> USERS</label>
                    <label class="inquiries-columns-check"><input type="checkbox" data-col="existingsw"> EXISTING SW</label>
                    <label class="inquiries-columns-check"><input type="checkbox" data-col="demomode"> DEMO MODE</label>
                    <label class="inquiries-columns-check"><input type="checkbox" data-col="products"> PRODUCTS</label>
                    <label class="inquiries-columns-check"><input type="checkbox" data-col="message"> MESSAGE</label>
                    <label class="inquiries-columns-check"><input type="checkbox" data-col="referralcode"> REFERRAL CODE</label>
                    <label class="inquiries-columns-check"><input type="checkbox" data-col="assignedby"> ASSIGNED BY</label>
                    <label class="inquiries-columns-check"><input type="checkbox" data-col="assignedto"> ASSIGNED TO</label>
                    <label class="inquiries-columns-check"><input type="checkbox" data-col="assigndate"> ASSIGN DATE</label>
                    <label class="inquiries-columns-check"><input type="checkbox" data-col="status"> STATUS</label>
                    <div class="inquiries-columns-actions">
                        <button type="button" class="inquiries-columns-action-btn" id="completedColumnsAll">All</button>
                        <button type="button" class="inquiries-columns-action-btn" id="completedColumnsNone">None</button>
                    </div>
                    <button type="button" class="inquiries-columns-reset" id="completedColumnsReset">Reset to default</button>
                </div>
            </div>
        </div>
    </div>
    <div class="inquiries-table-wrap">
        <div class="inquiries-table-scroll">
            <table class="dashboard-table inquiries-table" id="completedTable">
                <thead>
                    <tr class="inquiries-header-row">
                        <th data-col="inquiryid" class="inquiries-header-cell"><span class="inquiries-header-label">INQUIRY ID</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="completed" data-col="inquiryid"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="date" class="inquiries-header-cell"><span class="inquiries-header-label">INQUIRY DATE</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="completed" data-col="date"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="customername" class="inquiries-header-cell"><span class="inquiries-header-label">CUSTOMER NAME</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="completed" data-col="customername"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="source" class="inquiries-header-cell"><span class="inquiries-header-label">SOURCE</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="completed" data-col="source"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="postcode" class="inquiries-header-cell"><span class="inquiries-header-label">POSTCODE</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="completed" data-col="postcode"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="city" class="inquiries-header-cell"><span class="inquiries-header-label">CITY</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="completed" data-col="city"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="address" class="inquiries-header-cell"><span class="inquiries-header-label">ADDRESS</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="completed" data-col="address"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="contactno" class="inquiries-header-cell"><span class="inquiries-header-label">CONTACT NO</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="completed" data-col="contactno"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="businessnature" class="inquiries-header-cell"><span class="inquiries-header-label">BUSINESS NATURE</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="completed" data-col="businessnature"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="users" class="inquiries-header-cell"><span class="inquiries-header-label">USERS</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="completed" data-col="users"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="existingsw" class="inquiries-header-cell"><span class="inquiries-header-label">EXISTING SW</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="completed" data-col="existingsw"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="demomode" class="inquiries-header-cell"><span class="inquiries-header-label">DEMO MODE</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="completed" data-col="demomode"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="products" class="inquiries-header-cell"><span class="inquiries-header-label">PRODUCTS</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="completed" data-col="products"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="message" class="inquiries-header-cell"><span class="inquiries-header-label">MESSAGE</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="completed" data-col="message"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="referralcode" class="inquiries-header-cell"><span class="inquiries-header-label">REFERRAL CODE</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="completed" data-col="referralcode"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="assignedby" class="inquiries-header-cell"><span class="inquiries-header-label">ASSIGNED BY</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="completed" data-col="assignedby"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="assignedto" class="inquiries-header-cell"><span class="inquiries-header-label">ASSIGNED TO</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="completed" data-col="assignedto"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="assigndate" class="inquiries-header-cell"><span class="inquiries-header-label">ASSIGN DATE</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="completed" data-col="assigndate"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="status" class="inquiries-header-cell"><span class="inquiries-header-label">STATUS</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="completed" data-col="status"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th class="inquiries-col-action inquiries-header-cell"><span class="inquiries-header-label">ACTION</span><button type="button" class="inquiries-filter-clear" id="completedClearFilters">Clear filters</button></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($completed as $r)
                        @php
                            $ccompany = trim((string)($r->COMPANYNAME ?? ''));
                            $ccontact = trim((string)($r->CONTACTNAME ?? ''));
                            $custDisp = $ccompany !== '' && $ccontact !== ''
                                ? ($ccompany . ' - ' . $ccontact)
                                : ($ccompany !== '' ? $ccompany : ($ccontact !== '' ? $ccontact : '—'));
                            $addr1 = trim((string)($r->ADDRESS1 ?? ''));
                            $addr2 = trim((string)($r->ADDRESS2 ?? ''));
                            $addr = trim($addr1 . ' ' . $addr2);
                            $afullMsg = (string)($r->DESCRIPTION ?? '');
                            $afullMsgTrim = trim($afullMsg);
                            $amsgPreview = $afullMsgTrim === '' ? '—' : (mb_strlen($afullMsgTrim) > 30 ? (mb_substr($afullMsgTrim, 0, 30) . '…') : $afullMsgTrim);
                            $aisLongMsg = $afullMsgTrim !== '' && mb_strlen($afullMsgTrim) > 30;
                            $rawStatus = strtoupper(trim((string)($r->CURRENTSTATUS ?? '')));
                            $statusClass = 'inquiries-status-new';
                            switch ($rawStatus) {
                                case 'PENDING':   $statusClass = 'inquiries-status-pending'; break;
                                case 'FOLLOWUP':  $statusClass = 'inquiries-status-followup'; break;
                                case 'DEMO':      $statusClass = 'inquiries-status-demo'; break;
                                case 'CONFIRMED': $statusClass = 'inquiries-status-confirmed'; break;
                                case 'COMPLETED': $statusClass = 'inquiries-status-completed'; break;
                                case 'REWARDED':  $statusClass = 'inquiries-status-rewarded'; break;
                                case 'FAILED':    $statusClass = 'inquiries-status-failed'; break;
                                default:          $statusClass = 'inquiries-status-new'; break;
                            }
                            $statusDisp = $rawStatus !== '' ? $rawStatus : 'PENDING';
                            $assignDate = $r->LASTMODIFIED ? date('d/m/Y', strtotime($r->LASTMODIFIED)) : ($r->CREATEDAT ? date('d/m/Y', strtotime($r->CREATEDAT)) : '—');
                            $searchHaystack = strtolower(($r->COMPANYNAME ?? '').' '.($r->CONTACTNAME ?? '').' '.($r->LEADID ?? ''));
                            $productIds = $r->PRODUCTID ? array_map('trim', explode(',', (string)$r->PRODUCTID)) : [];
                            $pillOrder = [1=>10,3=>11,4=>12,2=>20,10=>21,8=>30,5=>31,6=>40,9=>50,7=>60,11=>70];
                            $productIds = array_values(array_filter(array_unique(array_map('intval', $productIds)), fn($v) => $v > 0));
                            usort($productIds, function($a,$b) use ($pillOrder) { return ($pillOrder[$a] ?? 1000+$a) <=> ($pillOrder[$b] ?? 1000+$b); });
                        @endphp
                        <tr class="rewards-row inquiry-row" data-search="{{ $searchHaystack }}">
                            <td data-col="inquiryid">#SQL-{{ $r->LEADID }}</td>
                            <td data-col="date">{{ $r->CREATEDAT ? date('d/m/Y', strtotime($r->CREATEDAT)) : '—' }}</td>
                            <td data-col="customername">{{ $custDisp }}</td>
                            <td data-col="source">{{ $r->CREATEDBY_NAME ?? ($r->CREATEDBY ?? '—') }}</td>
                            <td data-col="postcode">{{ $r->POSTCODE ?? '—' }}</td>
                            <td data-col="city">{{ $r->CITY ?? '—' }}</td>
                            <td data-col="address">{{ $addr !== '' ? $addr : '—' }}</td>
                            <td data-col="contactno">{{ $r->CONTACTNO ?? '—' }}</td>
                            <td data-col="businessnature">{{ $r->BUSINESSNATURE ?? '—' }}</td>
                            <td data-col="users">{{ $r->USERCOUNT ?? '—' }}</td>
                            <td data-col="existingsw">{{ $r->EXISTINGSOFTWARE ?? '—' }}</td>
                            <td data-col="demomode">{{ $r->DEMOMODE ?? '—' }}</td>
                            <td data-col="products">
                                @if(!empty($productIds))
                                    <div class="inquiries-pill-group">
                                        @foreach($productIds as $id)
                                            @if(isset($productLabels[(int)$id]))
                                                <span class="inquiries-pill inquiries-pill-p{{ (int)$id }}">{{ $productLabels[(int)$id] }}</span>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    —
                                @endif
                            </td>
                            <td data-col="message" class="inquiries-msg-cell {{ $aisLongMsg ? 'inquiries-msg-clickable' : '' }}" @if($aisLongMsg) data-full-message="{{ e($afullMsgTrim) }}" @endif>{{ $amsgPreview }}</td>
                            <td data-col="referralcode">{{ $r->REFERRALCODE ?? '—' }}</td>
                            <td data-col="assignedby">{{ $r->CREATEDBY_NAME ?? ($r->CREATEDBY ?? '—') }}</td>
                            <td data-col="assignedto">{{ $r->ASSIGNED_TO_NAME ?? ($r->ASSIGNED_TO ?? '—') }}</td>
                            <td data-col="assigndate">{{ $assignDate }}</td>
                            <td data-col="status"><span class="inquiries-status {{ $statusClass }}">{{ $statusDisp }}</span></td>
                            <td class="inquiries-col-action inquiries-action-cell">
                                <button type="button"
                                        class="inquiries-btn inquiries-btn-assign inquiries-view-status-btn"
                                        data-lead-id="{{ $r->LEADID }}"
                                        title="View Status"
                                        aria-label="View Status">
                                    <i class="bi bi-eye-fill" aria-hidden="true"></i>
                                </button>
                                <button type="button"
                                        class="inquiries-btn inquiries-btn-assign rewards-email-btn"
                                        data-lead-id="{{ $r->LEADID }}"
                                        title="Send Email"
                                        aria-label="Send Email">
                                    <i class="bi bi-envelope-fill" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="20" class="inquiries-empty">No completed payouts.</td></tr>
                    @endforelse
                    @for ($i = 0; $i < 10; $i++)
                        <tr class="rewards-placeholder-row" data-placeholder-index="{{ $i }}" style="display:none" aria-hidden="true"><td colspan="20">&nbsp;</td></tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
    <div class="inquiries-assigned-pagination" id="completedPagination" data-per-page="10" data-current-page="1">
            <span class="inquiries-assigned-pagination-info" id="completedPaginationInfo">Showing 0 to 0 of 0 entries (Page 1)</span>
            <div class="inquiries-assigned-pagination-nav">
                <button type="button" class="inquiries-btn inquiries-btn-secondary inquiries-pagination-btn" id="completedPaginationFirst" aria-label="First page">First</button>
                <button type="button" class="inquiries-btn inquiries-btn-secondary inquiries-pagination-btn" id="completedPaginationPrev" aria-label="Previous page">Previous</button>
                <span class="inquiries-assigned-page-numbers" id="completedPageNumbers"></span>
                <button type="button" class="inquiries-btn inquiries-btn-secondary inquiries-pagination-btn" id="completedPaginationNext" aria-label="Next page">Next</button>
                <button type="button" class="inquiries-btn inquiries-btn-secondary inquiries-pagination-btn" id="completedPaginationLast" aria-label="Last page">Last</button>
        </div>
    </div>
</section>
</div>

<div class="inquiries-tab-panel" id="rewardedPanel" role="tabpanel" hidden>
<section class="inquiries-mgmt-panel">
    <div class="inquiries-panel-header">
        <div class="inquiries-panel-title-wrap">
            <i class="bi bi-gift inquiries-panel-icon"></i>
            <h2 class="inquiries-panel-title">Rewarded</h2>
        </div>
    </div>
    <div class="inquiries-table-wrap">
        <div class="inquiries-table-scroll">
            <table class="dashboard-table inquiries-table" id="rewardedTable">
                <thead>
                    <tr class="inquiries-header-row">
                        <th data-col="inquiryid" class="inquiries-header-cell"><span class="inquiries-header-label">INQUIRY ID</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="rewarded" data-col="inquiryid"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="customername" class="inquiries-header-cell"><span class="inquiries-header-label">CUSTOMER NAME</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="rewarded" data-col="customername"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="postcode" class="inquiries-header-cell"><span class="inquiries-header-label">POSTCODE</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="rewarded" data-col="postcode"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="city" class="inquiries-header-cell"><span class="inquiries-header-label">CITY</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="rewarded" data-col="city"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="assignedto" class="inquiries-header-cell"><span class="inquiries-header-label">ASSIGNED TO</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="rewarded" data-col="assignedto"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="assigndate" class="inquiries-header-cell"><span class="inquiries-header-label">ASSIGN DATE</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="rewarded" data-col="assigndate"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="status" class="inquiries-header-cell"><span class="inquiries-header-label">STATUS</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter rewards-grid-filter" data-table="rewarded" data-col="status"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rewarded as $r)
                        @php
                            $ccompany = trim((string)($r->COMPANYNAME ?? ''));
                            $ccontact = trim((string)($r->CONTACTNAME ?? ''));
                            $custDisp = $ccompany !== '' && $ccontact !== ''
                                ? ($ccompany . ' - ' . $ccontact)
                                : ($ccompany !== '' ? $ccompany : ($ccontact !== '' ? $ccontact : '—'));
                            $rawStatus = strtoupper(trim((string)($r->CURRENTSTATUS ?? '')));
                            $statusClass = 'inquiries-status-new';
                            switch ($rawStatus) {
                                case 'PENDING':   $statusClass = 'inquiries-status-pending'; break;
                                case 'FOLLOWUP':  $statusClass = 'inquiries-status-followup'; break;
                                case 'DEMO':      $statusClass = 'inquiries-status-demo'; break;
                                case 'CONFIRMED': $statusClass = 'inquiries-status-confirmed'; break;
                                case 'COMPLETED': $statusClass = 'inquiries-status-completed'; break;
                                case 'REWARDED':  $statusClass = 'inquiries-status-rewarded'; break;
                                case 'FAILED':    $statusClass = 'inquiries-status-failed'; break;
                                default:          $statusClass = 'inquiries-status-new'; break;
                            }
                            $statusDisp = $rawStatus !== '' ? $rawStatus : 'PENDING';
                            $assignDate = $r->LASTMODIFIED
                                ? date('d/m/Y', strtotime($r->LASTMODIFIED))
                                : ($r->CREATEDAT ? date('d/m/Y', strtotime($r->CREATEDAT)) : '—');
                            $searchHaystack = strtolower(($r->COMPANYNAME ?? '').' '.($r->CONTACTNAME ?? '').' '.($r->LEADID ?? ''));
                        @endphp
                        <tr class="rewards-row inquiry-row" data-search="{{ $searchHaystack }}">
                            <td data-col="inquiryid">#SQL-{{ $r->LEADID }}</td>
                            <td data-col="customername">{{ $custDisp }}</td>
                            <td data-col="postcode">{{ $r->POSTCODE ?? '—' }}</td>
                            <td data-col="city">{{ $r->CITY ?? '—' }}</td>
                            <td data-col="assignedto">{{ $r->ASSIGNED_TO ?? '—' }}</td>
                            <td data-col="assigndate">{{ $assignDate }}</td>
                            <td data-col="status"><span class="inquiries-status {{ $statusClass }}">{{ $statusDisp }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="inquiries-empty">No rewarded payouts.</td></tr>
                    @endforelse
                    @for ($i = 0; $i < 10; $i++)
                        <tr class="rewards-placeholder-row" data-placeholder-index="{{ $i }}" style="display:none" aria-hidden="true"><td colspan="7">&nbsp;</td></tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
    <div class="inquiries-assigned-pagination" id="rewardedPagination" data-per-page="10" data-current-page="1">
        <span class="inquiries-assigned-pagination-info" id="rewardedPaginationInfo">Showing 0 to 0 of 0 entries (Page 1)</span>
        <div class="inquiries-assigned-pagination-nav">
            <button type="button" class="inquiries-btn inquiries-btn-secondary inquiries-pagination-btn" id="rewardedPaginationFirst" aria-label="First page">First</button>
            <button type="button" class="inquiries-btn inquiries-btn-secondary inquiries-pagination-btn" id="rewardedPaginationPrev" aria-label="Previous page">Previous</button>
            <span class="inquiries-assigned-page-numbers" id="rewardedPageNumbers"></span>
            <button type="button" class="inquiries-btn inquiries-btn-secondary inquiries-pagination-btn" id="rewardedPaginationNext" aria-label="Next page">Next</button>
            <button type="button" class="inquiries-btn inquiries-btn-secondary inquiries-pagination-btn" id="rewardedPaginationLast" aria-label="Last page">Last</button>
        </div>
    </div>
</section>
</div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var COMPLETED_STORAGE_KEY = 'payoutCompletedVisibleColumns';
    var COMPLETED_DEFAULT_COLUMNS = ['inquiryid','customername','postcode','city','assignedto','assigndate','status'];
    var COMPLETED_ALL_COLUMNS = ['inquiryid','date','customername','source','postcode','city','address','contactno','businessnature','users','existingsw','demomode','products','message','referralcode','assignedby','assignedto','assigndate','status'];

    function getCompletedVisibleColumns() {
        try {
            var raw = localStorage.getItem(COMPLETED_STORAGE_KEY);
            if (raw !== null) {
                var arr = JSON.parse(raw);
                if (Array.isArray(arr)) return arr;
            }
        } catch (e) {}
        return COMPLETED_DEFAULT_COLUMNS.slice();
    }
    function setCompletedVisibleColumns(cols) {
        try { localStorage.setItem(COMPLETED_STORAGE_KEY, JSON.stringify(cols)); } catch (e) {}
    }
    function applyCompletedColumns(visible) {
        var table = document.getElementById('completedTable');
        if (!table) return;
        COMPLETED_ALL_COLUMNS.forEach(function(col) {
            var show = visible.indexOf(col) !== -1;
            table.querySelectorAll('th[data-col="' + col + '"], td[data-col="' + col + '"]').forEach(function(el) {
                el.style.display = show ? '' : 'none';
            });
        });
        var showAction = Array.isArray(visible) && visible.length > 0;
        table.querySelectorAll('th.inquiries-col-action, td.inquiries-col-action').forEach(function(el) {
            el.style.display = showAction ? '' : 'none';
        });
    }
    function syncCompletedCheckboxes(visible) {
        var menu = document.getElementById('completedColumnsMenu');
        if (!menu) return;
        menu.querySelectorAll('input[data-col]').forEach(function(cb) {
            var col = cb.getAttribute('data-col');
            cb.checked = visible.indexOf(col) !== -1;
        });
    }
    function refreshCompletedColumnState() {
        var visible = getCompletedVisibleColumns();
        syncCompletedCheckboxes(visible);
        applyCompletedColumns(visible);
    }

    refreshCompletedColumnState();

    var completedColBtn = document.getElementById('completedColumnsBtn');
    var completedColMenu = document.getElementById('completedColumnsMenu');
    if (completedColBtn && completedColMenu) {
        completedColBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            var isOpen = !completedColMenu.hidden;
            completedColMenu.hidden = isOpen;
            completedColBtn.setAttribute('aria-expanded', !isOpen);
            if (!isOpen) {
                completedColMenu.scrollTop = 0;
                refreshCompletedColumnState();
            }
        });
        document.addEventListener('click', function() {
            completedColMenu.hidden = true;
            completedColBtn.setAttribute('aria-expanded', 'false');
        });
        completedColMenu.addEventListener('click', function(e) { e.stopPropagation(); });
    }
    if (completedColMenu) {
        completedColMenu.querySelectorAll('input[data-col]').forEach(function(cb) {
            cb.addEventListener('change', function() {
                var visible = [];
                completedColMenu.querySelectorAll('input[data-col]:checked').forEach(function(c) {
                    visible.push(c.getAttribute('data-col'));
                });
                setCompletedVisibleColumns(visible);
                applyCompletedColumns(visible);
            });
        });
    }
    var completedReset = document.getElementById('completedColumnsReset');
    if (completedReset) {
        completedReset.addEventListener('click', function() {
            setCompletedVisibleColumns(COMPLETED_DEFAULT_COLUMNS.slice());
            refreshCompletedColumnState();
            var wrap = document.querySelector('#completedPanel .inquiries-table-scroll');
            if (wrap) wrap.scrollLeft = 0;
        });
    }
    var completedAll = document.getElementById('completedColumnsAll');
    if (completedAll) {
        completedAll.addEventListener('click', function() {
            setCompletedVisibleColumns(COMPLETED_ALL_COLUMNS.slice());
            refreshCompletedColumnState();
        });
    }
    var completedNone = document.getElementById('completedColumnsNone');
    if (completedNone) {
        completedNone.addEventListener('click', function() {
            setCompletedVisibleColumns([]);
            refreshCompletedColumnState();
        });
    }

    document.querySelectorAll('.inquiries-sync-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (btn.classList.contains('is-syncing')) return;
            btn.classList.add('is-syncing');
            var icon = btn.querySelector('.inquiries-sync-icon');
            if (icon) icon.classList.add('spinning');
            window.location.reload();
        });
    });

    var completedClearFilters = document.getElementById('completedClearFilters');
    if (completedClearFilters) {
        completedClearFilters.addEventListener('click', function() {
            var table = document.getElementById('completedTable');
            if (table) table.querySelectorAll('thead .rewards-grid-filter').forEach(function(inp) { inp.value = ''; });
            applyTableFilter('completedTable');
        });
    }

    var COMPLETED_PER_PAGE = 10;
    var REWARDED_PER_PAGE = 10;

    function getVisibleDataRows(table) {
        if (!table) return [];
        var rows = table.querySelectorAll('tbody tr.rewards-row');
        var out = [];
        for (var i = 0; i < rows.length; i++) {
            if (rows[i].style.display !== 'none') out.push(rows[i]);
        }
        return out;
    }

    function applyCompletedPagination() {
        var table = document.getElementById('completedTable');
        var pagEl = document.getElementById('completedPagination');
        var infoEl = document.getElementById('completedPaginationInfo');
        var firstBtn = document.getElementById('completedPaginationFirst');
        var prevBtn = document.getElementById('completedPaginationPrev');
        var nextBtn = document.getElementById('completedPaginationNext');
        var lastBtn = document.getElementById('completedPaginationLast');
        var pageNumbersEl = document.getElementById('completedPageNumbers');
        if (!table || !pagEl) return;
        var visible = getVisibleDataRows(table);
        var total = visible.length;
        var perPage = COMPLETED_PER_PAGE;
        var lastPage = total > 0 ? Math.ceil(total / perPage) : 1;
        var current = parseInt(pagEl.getAttribute('data-current-page') || '1', 10);
        current = Math.max(1, Math.min(current, lastPage));
        pagEl.setAttribute('data-current-page', String(current));
        var start = (current - 1) * perPage;
        var end = Math.min(start + perPage, total);
        var visibleOnPage = end - start;
        for (var i = 0; i < visible.length; i++) {
            visible[i].style.display = (i >= start && i < end) ? '' : 'none';
        }
        var placeholders = table.querySelectorAll('tbody tr.rewards-placeholder-row');
        var slotsToFill = (total === 0) ? 0 : Math.max(0, 10 - visibleOnPage);
        for (var pi = 0; pi < placeholders.length; pi++) {
            placeholders[pi].style.display = pi < slotsToFill ? '' : 'none';
        }
        var from = total === 0 ? 0 : start + 1;
        var to = end;
        if (infoEl) infoEl.textContent = 'Showing ' + from + ' to ' + to + ' of ' + total + ' entries (Page ' + current + ')';
        if (firstBtn) firstBtn.disabled = current <= 1;
        if (prevBtn) prevBtn.disabled = current <= 1;
        if (nextBtn) nextBtn.disabled = current >= lastPage;
        if (lastBtn) lastBtn.disabled = current >= lastPage;
        if (pageNumbersEl) {
            var html = '';
            for (var p = 1; p <= lastPage; p++) {
                var active = p === current;
                html += '<button type="button" class="inquiries-btn inquiries-btn-secondary inquiries-pagination-btn inquiries-page-num' + (active ? ' active' : '') + '" data-page="' + p + '" aria-label="Page ' + p + '"' + (active ? ' aria-current="page"' : '') + '>' + p + '</button>';
            }
            pageNumbersEl.innerHTML = html;
            pageNumbersEl.querySelectorAll('[data-page]').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var p = parseInt(btn.getAttribute('data-page'), 10);
                    pagEl.setAttribute('data-current-page', String(p));
                    applyCompletedPagination();
                });
            });
        }
    }

    function applyRewardedPagination() {
        var table = document.getElementById('rewardedTable');
        var pagEl = document.getElementById('rewardedPagination');
        var infoEl = document.getElementById('rewardedPaginationInfo');
        var firstBtn = document.getElementById('rewardedPaginationFirst');
        var prevBtn = document.getElementById('rewardedPaginationPrev');
        var nextBtn = document.getElementById('rewardedPaginationNext');
        var lastBtn = document.getElementById('rewardedPaginationLast');
        var pageNumbersEl = document.getElementById('rewardedPageNumbers');
        if (!table || !pagEl) return;
        var visible = getVisibleDataRows(table);
        var total = visible.length;
        var perPage = REWARDED_PER_PAGE;
        var lastPage = total > 0 ? Math.ceil(total / perPage) : 1;
        var current = parseInt(pagEl.getAttribute('data-current-page') || '1', 10);
        current = Math.max(1, Math.min(current, lastPage));
        pagEl.setAttribute('data-current-page', String(current));
        var start = (current - 1) * perPage;
        var end = Math.min(start + perPage, total);
        var visibleOnPage = end - start;
        for (var i = 0; i < visible.length; i++) {
            visible[i].style.display = (i >= start && i < end) ? '' : 'none';
        }
        var placeholders = table.querySelectorAll('tbody tr.rewards-placeholder-row');
        var slotsToFill = (total === 0) ? 0 : Math.max(0, 10 - visibleOnPage);
        for (var pi = 0; pi < placeholders.length; pi++) {
            placeholders[pi].style.display = pi < slotsToFill ? '' : 'none';
        }
        var from = total === 0 ? 0 : start + 1;
        var to = end;
        if (infoEl) infoEl.textContent = 'Showing ' + from + ' to ' + to + ' of ' + total + ' entries (Page ' + current + ')';
        if (firstBtn) firstBtn.disabled = current <= 1;
        if (prevBtn) prevBtn.disabled = current <= 1;
        if (nextBtn) nextBtn.disabled = current >= lastPage;
        if (lastBtn) lastBtn.disabled = current >= lastPage;
        if (pageNumbersEl) {
            var html = '';
            for (var p = 1; p <= lastPage; p++) {
                var active = p === current;
                html += '<button type="button" class="inquiries-btn inquiries-btn-secondary inquiries-pagination-btn inquiries-page-num' + (active ? ' active' : '') + '" data-page="' + p + '" aria-label="Page ' + p + '"' + (active ? ' aria-current="page"' : '') + '>' + p + '</button>';
            }
            pageNumbersEl.innerHTML = html;
            pageNumbersEl.querySelectorAll('[data-page]').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var p = parseInt(btn.getAttribute('data-page'), 10);
                    pagEl.setAttribute('data-current-page', String(p));
                    applyRewardedPagination();
                });
            });
        }
    }

    function applyTableFilter(tableId) {
        var table = document.getElementById(tableId);
        var searchInput = document.getElementById('payoutSearchInput');
        if (!table) return;
        var q = (searchInput && searchInput.value) ? searchInput.value.toLowerCase().trim() : '';
        var filters = {};
        table.querySelectorAll('thead .rewards-grid-filter').forEach(function(inp) {
            var col = inp.getAttribute('data-col');
            var val = (inp.value || '').toLowerCase().trim();
            if (col && val) filters[col] = val;
        });
        table.querySelectorAll('tbody tr.rewards-row').forEach(function(row) {
            var hay = (row.getAttribute('data-search') || '').toLowerCase();
            var searchMatch = !q || hay.indexOf(q) !== -1;
            var colMatch = true;
            for (var col in filters) {
                var cell = row.querySelector('td[data-col="' + col + '"]');
                var cellText = (cell && cell.textContent) ? cell.textContent.toLowerCase().trim() : '';
                if (cellText.indexOf(filters[col]) === -1) { colMatch = false; break; }
            }
            row.style.display = (searchMatch && colMatch) ? '' : 'none';
        });
        if (tableId === 'completedTable') {
            var cp = document.getElementById('completedPagination');
            if (cp) cp.setAttribute('data-current-page', '1');
            applyCompletedPagination();
        } else if (tableId === 'rewardedTable') {
            var rp = document.getElementById('rewardedPagination');
            if (rp) rp.setAttribute('data-current-page', '1');
            applyRewardedPagination();
        }
    }
    function bindTable(tableId) {
        var table = document.getElementById(tableId);
        if (!table) return;
        table.querySelectorAll('thead .rewards-grid-filter').forEach(function(inp) {
            inp.addEventListener('input', function() { applyTableFilter(tableId); });
        });
    }
    bindTable('completedTable');
    bindTable('rewardedTable');

    applyCompletedPagination();
    applyRewardedPagination();

    var completedPagNav = document.querySelector('#completedPagination .inquiries-assigned-pagination-nav');
    if (completedPagNav) {
        completedPagNav.addEventListener('click', function(e) {
            var btn = e.target.closest('button');
            if (!btn || !btn.id) return;
            var pagEl = document.getElementById('completedPagination');
            if (!pagEl) return;
            var cur = parseInt(pagEl.getAttribute('data-current-page') || '1', 10);
            var last = Math.max(1, Math.ceil(getVisibleDataRows(document.getElementById('completedTable')).length / COMPLETED_PER_PAGE));
            if (btn.id === 'completedPaginationFirst') pagEl.setAttribute('data-current-page', '1');
            else if (btn.id === 'completedPaginationPrev') pagEl.setAttribute('data-current-page', String(Math.max(1, cur - 1)));
            else if (btn.id === 'completedPaginationNext') pagEl.setAttribute('data-current-page', String(Math.min(last, cur + 1)));
            else if (btn.id === 'completedPaginationLast') pagEl.setAttribute('data-current-page', String(last));
            else return;
            applyCompletedPagination();
        });
    }
    var rewardedPagNav = document.querySelector('#rewardedPagination .inquiries-assigned-pagination-nav');
    if (rewardedPagNav) {
        rewardedPagNav.addEventListener('click', function(e) {
            var btn = e.target.closest('button');
            if (!btn || !btn.id) return;
            var pagEl = document.getElementById('rewardedPagination');
            if (!pagEl) return;
            var cur = parseInt(pagEl.getAttribute('data-current-page') || '1', 10);
            var last = Math.max(1, Math.ceil(getVisibleDataRows(document.getElementById('rewardedTable')).length / REWARDED_PER_PAGE));
            if (btn.id === 'rewardedPaginationFirst') pagEl.setAttribute('data-current-page', '1');
            else if (btn.id === 'rewardedPaginationPrev') pagEl.setAttribute('data-current-page', String(Math.max(1, cur - 1)));
            else if (btn.id === 'rewardedPaginationNext') pagEl.setAttribute('data-current-page', String(Math.min(last, cur + 1)));
            else if (btn.id === 'rewardedPaginationLast') pagEl.setAttribute('data-current-page', String(last));
            else return;
            applyRewardedPagination();
        });
    }

    var payoutSearchInput = document.getElementById('payoutSearchInput');
    var payoutSearchBtn = document.getElementById('payoutSearchBtn');
    var payoutClearBtn = document.getElementById('payoutClearSearchBtn');
    function applyAllTables() {
        applyTableFilter('completedTable');
        applyTableFilter('rewardedTable');
    }
    if (payoutSearchInput) {
        payoutSearchInput.addEventListener('input', applyAllTables);
        payoutSearchInput.addEventListener('keyup', function(e) { if (e.key === 'Enter') applyAllTables(); });
    }
    if (payoutSearchBtn) {
        payoutSearchBtn.addEventListener('click', applyAllTables);
    }
    if (payoutClearBtn) {
        payoutClearBtn.addEventListener('click', function() {
            if (payoutSearchInput) payoutSearchInput.value = '';
            ['completedTable','rewardedTable'].forEach(function(tid) {
                var t = document.getElementById(tid);
                if (!t) return;
                t.querySelectorAll('thead .rewards-grid-filter').forEach(function(inp) { inp.value = ''; });
            });
            applyAllTables();
        });
    }

    document.querySelectorAll('.inquiries-tab').forEach(function(tab) {
        tab.addEventListener('click', function() {
            var t = this.getAttribute('data-tab');
            document.querySelectorAll('.inquiries-tab').forEach(function(bt) {
                bt.classList.toggle('active', bt.getAttribute('data-tab') === t);
                bt.setAttribute('aria-selected', bt.getAttribute('data-tab') === t ? 'true' : 'false');
            });
            var completedPanel = document.getElementById('completedPanel');
            var rewardedPanel = document.getElementById('rewardedPanel');
            if (completedPanel) { completedPanel.classList.toggle('active', t === 'completed'); completedPanel.hidden = t !== 'completed'; }
            if (rewardedPanel) { rewardedPanel.classList.toggle('active', t === 'rewarded'); rewardedPanel.hidden = t !== 'rewarded'; }
        });
    });
});
</script>
@endpush
