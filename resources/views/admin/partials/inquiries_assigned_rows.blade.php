@forelse($assigned as $r)
<tr class="inquiry-row" data-search="{{ strtolower(($r->COMPANYNAME ?? '').' '.($r->CONTACTNAME ?? '').' '.($r->LEADID ?? '')) }}">
    <td data-col="inquiryid">#SQL-{{ $r->LEADID }}</td>
    <td data-col="date">{{ $r->CREATEDAT ? date('d/m/Y', strtotime($r->CREATEDAT)) : '—' }}</td>
    @php
        $ccompany = trim((string)($r->COMPANYNAME ?? ''));
        $ccontact = trim((string)($r->CONTACTNAME ?? ''));
        $custDisp = $ccompany !== '' && $ccontact !== '' ? ($ccompany . ' - ' . $ccontact) : ($ccompany !== '' ? $ccompany : ($ccontact !== '' ? $ccontact : '—'));
    @endphp
    <td data-col="customername">{{ $custDisp }}</td>
    <td data-col="source">{{ $r->CREATEDBY_NAME ?? ($r->CREATEDBY ?? '—') }}</td>
    <td data-col="postcode">{{ $r->POSTCODE ?? '—' }}</td>
    <td data-col="city">{{ $r->CITY ?? '—' }}</td>
    @php
        $addr1 = trim((string)($r->ADDRESS1 ?? ''));
        $addr2 = trim((string)($r->ADDRESS2 ?? ''));
        $addr = trim($addr1 . ' ' . $addr2);
    @endphp
    <td data-col="address">{{ $addr !== '' ? $addr : '—' }}</td>
    <td data-col="contactno">{{ $r->CONTACTNO ?? '—' }}</td>
    <td data-col="businessnature">{{ $r->BUSINESSNATURE ?? '—' }}</td>
    <td data-col="users">{{ $r->USERCOUNT ?? '—' }}</td>
    <td data-col="existingsw">{{ $r->EXISTINGSOFTWARE ?? '—' }}</td>
    <td data-col="demomode">{{ $r->DEMOMODE ?? '—' }}</td>
    <td data-col="products">
        @php
            $ids = $r->PRODUCTID ? array_map('trim', explode(',', (string)$r->PRODUCTID)) : [];
            $pillOrder = [
                1 => 10, 3 => 11, 4 => 12,
                2 => 20, 10 => 21,
                8 => 30, 5 => 31,
                6 => 40,
                9 => 50,
                7 => 60,
                11 => 70,
            ];
            $ids = array_values(array_filter(array_unique(array_map('intval', $ids)), fn($v) => $v > 0));
            usort($ids, function($a, $b) use ($pillOrder) {
                $oa = $pillOrder[$a] ?? (1000 + $a);
                $ob = $pillOrder[$b] ?? (1000 + $b);
                return $oa <=> $ob;
            });
        @endphp
        @if(!empty($ids))
            <div class="inquiries-pill-group">
                @foreach($ids as $id)
                    @if(isset($productLabels[(int)$id]))
                        <span class="inquiries-pill inquiries-pill-p{{ (int)$id }}">{{ $productLabels[(int)$id] }}</span>
                    @endif
                @endforeach
            </div>
        @else
            —
        @endif
    </td>
    @php
        $afullMsg = (string)($r->DESCRIPTION ?? '');
        $afullMsgTrim = trim($afullMsg);
        $amsgPreview = $afullMsgTrim === '' ? '—' : (mb_strlen($afullMsgTrim) > 30 ? (mb_substr($afullMsgTrim, 0, 30) . '…') : $afullMsgTrim);
        $aisLongMsg = $afullMsgTrim !== '' && mb_strlen($afullMsgTrim) > 30;
    @endphp
    <td data-col="message" class="inquiries-msg-cell {{ $aisLongMsg ? 'inquiries-msg-clickable' : '' }}"
        @if($aisLongMsg) data-full-message="{{ e($afullMsgTrim) }}" @endif>
        {{ $amsgPreview }}
    </td>
    <td data-col="referralcode">{{ $r->REFERRALCODE ?? '—' }}</td>
    <td data-col="assignedby">{{ $r->CREATEDBY_NAME ?? ($r->CREATEDBY ?? '—') }}</td>
    <td data-col="assignedto">{{ $r->ASSIGNED_TO_NAME ?? ($r->ASSIGNED_TO ?? '—') }}</td>
    <td data-col="assigndate">{{ $r->LASTMODIFIED ? date('d/m/Y', strtotime($r->LASTMODIFIED)) : ($r->CREATEDAT ? date('d/m/Y', strtotime($r->CREATEDAT)) : '—') }}</td>
    @php
        $arawStatus = strtoupper(trim((string)($r->CURRENTSTATUS ?? '')));
        $astatusClass = 'inquiries-status-new';
        switch ($arawStatus) {
            case 'PENDING':    $astatusClass = 'inquiries-status-pending'; break;
            case 'FOLLOWUP':   $astatusClass = 'inquiries-status-followup'; break;
            case 'DEMO':       $astatusClass = 'inquiries-status-demo'; break;
            case 'CONFIRMED':  $astatusClass = 'inquiries-status-confirmed'; break;
            case 'COMPLETED':  $astatusClass = 'inquiries-status-completed'; break;
            case 'REWARDED':   $astatusClass = 'inquiries-status-rewarded'; break;
            default:           $astatusClass = 'inquiries-status-new'; break;
        }
    @endphp
    <td data-col="status"><span class="inquiries-status {{ $astatusClass }}">{{ $arawStatus !== '' ? $arawStatus : 'PENDING' }}</span></td>
    <td class="inquiries-col-action inquiries-action-cell">
        <button type="button" class="inquiries-icon-btn" title="Reassign"><i class="bi bi-arrow-repeat"></i></button>
        <button type="button" class="inquiries-icon-btn" title="View"><i class="bi bi-eye"></i></button>
        <a href="#" class="inquiries-text-link">View Info</a>
        <a href="#" class="inquiries-text-link">View Status</a>
    </td>
</tr>
@empty
<tr><td colspan="20" class="inquiries-empty">No assigned inquiries.</td></tr>
@endforelse

