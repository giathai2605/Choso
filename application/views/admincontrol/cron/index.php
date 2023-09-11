<div class="row">
<div class="col-12">
	<div class="cron-title mb-4">
		<i class="fas fa-tasks"></i> <?= __('admin.cron_job') ?>
	</div>

	<div class="card m-b-30">
		<div class="card-body">
			<label class="cron-desc"><i class="fas fa-circle"></i> <?= __('admin.wallet_transactions_cron_job') ?></label>
			<div class="cron-div">
				<div class="copy trans-copy" onclick="copyTrans()"><span><?= __('admin.copy') ?></span></div>
				<input type="text" class="mt-4 cron-input" id="cron-trans" name="" value="curl <?= base_url('/cronJob/transaction') ?>">
			</div>
		</div>
	</div>

	<div class="card m-b-30">
		<div class="card-body">
			<label class="cron-desc"><i class="fas fa-circle"></i> <?= __('admin.auto_process_in_wallet_transaction_cron_job') ?></label>
			<div class="cron-div">
				<div class="copy auto-wallet-copy" onclick="copyAutoWallet()"><span><?= __('admin.copy') ?></span></div>
				<input type="text" class="mt-4 cron-input" id="cron-auto-wallet" name="" value="curl <?= base_url('/cronJob/autoProcessInWalletTransactions') ?>">
			</div>
		</div>
	</div>

	 
	<div class="card m-b-30">
		<div class="card-body">
			<label class="cron-desc"><i class="fas fa-circle"></i> <?= __('admin.campaigns_validator_cron_job') ?></label>
			<div class="cron-div">
				<div class="copy camp-copy" onclick="copyCamp()"><span><?= __('admin.copy') ?></span></div>
				<input type="text" class="mt-4 cron-input" id="cron-camp" name="" value="curl <?= base_url('/cronJob/check_campaign_security') ?>">
			</div>
		</div>
	</div>
	<div class="card m-b-30">
		<div class="card-body">
			<label class="cron-desc"><i class="fas fa-circle"></i> <?= __('admin.expire_package_notification') ?></label>
			<div class="cron-div">
				<div class="copy expi-copy" onclick="copyExpi()"><span><?= __('admin.copy') ?></span></div>
				<input type="text" class="mt-4 cron-input" id="cron-expi" name="" value="curl <?= base_url('/cronJob/expire_package_notification') ?>">
			</div>
		</div>
	</div>
	<div class="card m-b-30">
		<div class="card-body">
			<label class="cron-desc"><i class="fas fa-circle"></i> <?= __('admin.check_vendor_limit') ?></label>
			<div class="cron-div">
				<div class="copy ven-copy" onclick="copyVen()"><span><?= __('admin.copy') ?></span></div>
				<input type="text" class="mt-4 cron-input" id="cron-ven" name="" value="curl <?= base_url('/cronJob/check_ven_limitation') ?>">
			</div>
		</div>
	</div>
		<div class="card m-b-30">
		<div class="card-body">
			<label class="cron-desc"><i class="fas fa-circle"></i> <?= __('admin.check_award_level') ?></label>
			<div class="cron-div">
				<div class="copy ven-copy" onclick="copyVen()"><span><?= __('admin.copy') ?></span></div>
				<input type="text" class="mt-4 cron-input" id="cron-ven" name="" value="curl <?= base_url('/cronJob/check_award_level') ?>">
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function copyTrans() {
	    var textBox = document.getElementById("cron-trans");
	    textBox.select();
	    document.execCommand("copy");
	    $('.trans-copy span').text('copied!');
	    setTimeout(function(){
	    	clearSelection();
	    	$('.trans-copy span').text('Copy');
	    }, 1000);
	}

	function copyAutoWallet() {
	    var textBox = document.getElementById("cron-auto-wallet");
	    textBox.select();
	    document.execCommand("copy");
	    $('.auto-wallet-copy span').text('copied!');
	    setTimeout(function(){
	    	clearSelection();
	    	$('.auto-wallet-copy span').text('Copy');
	    }, 1000);
	}

	function copyCamp() {
	    var textBox = document.getElementById("cron-camp");
	    textBox.select();
	    document.execCommand("copy");
	    $('.camp-copy span').text('copied!');
	    setTimeout(function(){
	    	clearSelection();
	    	$('.camp-copy span').text('Copy');
	    }, 1000);
	}

	function copyExpi() {
	    var textBox = document.getElementById("cron-expi");
	    textBox.select();
	    document.execCommand("copy");
	    $('.expi-copy span').text('copied!');
	    setTimeout(function(){
	    	clearSelection();
	    	$('.expi-copy span').text('Copy');
	    }, 1000);
	}

	function copyVen() {
	    var textBox = document.getElementById("cron-ven");
	    textBox.select();
	    document.execCommand("copy");
	    $('.ven-copy span').text('copied!');
	    setTimeout(function(){
	    	clearSelection();
	    	$('.ven-copy span').text('Copy');
	    }, 1000);
	}

	function clearSelection() {
	    if (window.getSelection) window.getSelection().removeAllRanges();
	    else if (document.selection) document.selection.empty();
	}
</script>