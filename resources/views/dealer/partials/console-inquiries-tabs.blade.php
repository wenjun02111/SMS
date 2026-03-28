@php
    $dealerConsoleTab = $dealerConsoleTab ?? 'inquiries';
    $dealerInquiryCount = (int) ($dealerInquiryCount ?? 0);
    $dealerPendingPayoutCount = (int) ($dealerPendingPayoutCount ?? 0);
@endphp
<nav class="dealer-console-tabs" aria-label="Dealer inquiry sections">
    <a href="{{ route('dealer.inquiries') }}"
       class="dealer-console-tab {{ $dealerConsoleTab === 'inquiries' ? 'dealer-console-tab-active' : '' }}"
       aria-current="{{ $dealerConsoleTab === 'inquiries' ? 'page' : 'false' }}">
        <span class="inquiries-tab-label">
            My Inquiries
            <span class="inquiries-tab-count">{{ number_format($dealerInquiryCount) }}</span>
        </span>
    </a>
    <a href="{{ route('dealer.payouts') }}"
       class="dealer-console-tab {{ $dealerConsoleTab === 'pending-payouts' ? 'dealer-console-tab-active' : '' }}"
       aria-current="{{ $dealerConsoleTab === 'pending-payouts' ? 'page' : 'false' }}">
        <span class="inquiries-tab-label">
            Pending Payouts
            <span class="inquiries-tab-count">{{ number_format($dealerPendingPayoutCount) }}</span>
        </span>
    </a>
</nav>
