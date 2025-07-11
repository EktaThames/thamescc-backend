<?php echo view_render_event('bagisto.shop.layout.footer.before'); ?>


<!--
    The category repository is injected directly here because there is no way
    to retrieve it from the view composer, as this is an anonymous component.
-->
<?php $themeCustomizationRepository = app('Webkul\Theme\Repositories\ThemeCustomizationRepository'); ?>

<?php
    $footer = \Webkul\Shop\Models\FooterSetting::first();
?>

<footer style="background:#232221; color:#fff; padding:40px 0 0 0; font-family:inherit;">
    <div style="display:flex; flex-wrap:wrap; justify-content:space-between; max-width:1750px; margin:0 auto; gap:40px;">
        <div style="flex:1; min-width:220px;">
            <a
                href="<?php echo e(route('shop.home.index')); ?>"
                aria-label="<?php echo app('translator')->get('shop::app.components.layouts.header.bagisto'); ?>"
            >
                <img
                    src="<?php echo e(core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg')); ?>"
                    width="131"
                    height="29"
                    alt="<?php echo e(config('app.name')); ?>"
                >
            </a>
            <p style="margin-top:10px;"><?php echo $footer?->about_text; ?></p>
            <div style="margin-top:20px;">
                <span style="font-weight:bold;">Socials</span>
                <div style="display:flex; gap:15px; margin-top:10px;">
                <?php if($footer?->twitter): ?>
                <a href="<?php echo e($footer->twitter); ?>" target="_blank" style="color:#fff; font-size:22px;">
                    <svg width="34" height="30" viewBox="0 0 34 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M33.4256 4.77069C33.3549 4.59929 33.2348 4.45273 33.0808 4.34954C32.9267 4.24636 32.7454 4.19119 32.56 4.19101H27.6225C26.9978 3.06436 26.0853 2.12363 24.9783 1.46482C23.8712 0.806018 22.6092 0.452727 21.3209 0.441006C20.3853 0.429016 19.4567 0.604193 18.5897 0.956241C17.7228 1.30829 16.9349 1.8301 16.2725 2.49101C15.5898 3.16083 15.0479 3.96037 14.6787 4.84264C14.3095 5.72491 14.1204 6.6721 14.1225 7.62851V8.98163C7.56 7.41913 2.15376 2.02538 2.09126 1.96913C1.96534 1.84409 1.80652 1.75735 1.63326 1.719C1.46 1.68065 1.27941 1.69226 1.11249 1.75249C0.94557 1.81271 0.799168 1.91907 0.690303 2.05921C0.581438 2.19934 0.514581 2.3675 0.497505 2.54413C-0.166558 9.92226 1.96938 14.8488 3.87875 17.6832C4.86579 19.168 6.08253 20.4865 7.48344 21.5894C5.06313 24.5582 1.02407 26.1035 0.980317 26.1207C0.846881 26.1701 0.726433 26.2492 0.6281 26.352C0.529768 26.4548 0.45613 26.5787 0.412767 26.7142C0.369404 26.8497 0.357452 26.9933 0.377819 27.1341C0.398185 27.2749 0.450335 27.4093 0.530317 27.5269C0.685005 27.7582 2.21313 29.816 7.56001 29.816C18.4788 29.816 27.5959 21.3785 28.4694 10.5441L33.2225 5.79257C33.3536 5.66143 33.4429 5.49434 33.4791 5.31245C33.5152 5.13055 33.4966 4.94201 33.4256 4.77069ZM26.8975 9.46601C26.736 9.62709 26.6388 9.84152 26.6241 10.0691C25.9866 20.091 17.6116 27.941 7.56001 27.941C5.37251 27.941 4.00375 27.5644 3.17563 27.191C4.94126 26.3035 7.81938 24.5535 9.58969 21.8988C9.6603 21.7926 9.70849 21.6731 9.73133 21.5477C9.75416 21.4222 9.75116 21.2934 9.7225 21.1691C9.69356 21.0441 9.63924 20.9263 9.5629 20.8231C9.48657 20.7199 9.38986 20.6334 9.27876 20.5691C9.25844 20.5566 7.22719 19.341 5.37251 16.5504C3.18501 13.2535 2.13969 9.25819 2.24751 4.64101C4.5725 6.60976 9.36782 10.1238 14.9038 11.0473C15.0382 11.07 15.1761 11.0631 15.3076 11.0271C15.4392 10.9911 15.5613 10.9268 15.6654 10.8387C15.7695 10.7506 15.8532 10.6409 15.9106 10.5172C15.9679 10.3934 15.9976 10.2586 15.9975 10.1223V7.62851C15.9961 6.92047 16.1362 6.2193 16.4096 5.56619C16.683 4.91308 17.0843 4.32121 17.5897 3.82538C18.0763 3.33948 18.6551 2.95567 19.2921 2.69648C19.9291 2.43729 20.6114 2.30793 21.2991 2.31601C23.3975 2.34257 25.3616 3.62382 26.1803 5.50351C26.2533 5.67072 26.3735 5.813 26.5261 5.91291C26.6788 6.01283 26.8573 6.06603 27.0397 6.06601H30.2959L26.8975 9.46601Z" fill="#777777"/>
                    </svg>
                </a>
            <?php endif; ?>
            <?php if($footer?->instagram): ?>
                <a href="<?php echo e($footer->instagram); ?>" target="_blank" style="color:#fff; font-size:22px;">
                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.5601 9.98626C15.9991 9.98626 14.4733 10.4491 13.1754 11.3163C11.8776 12.1835 10.866 13.4161 10.2687 14.8582C9.67132 16.3003 9.51503 17.8872 9.81955 19.4181C10.1241 20.949 10.8757 22.3553 11.9795 23.459C13.0832 24.5628 14.4894 25.3144 16.0204 25.6189C17.5513 25.9235 19.1382 25.7672 20.5803 25.1698C22.0224 24.5725 23.2549 23.5609 24.1221 22.2631C24.9893 20.9652 25.4522 19.4393 25.4522 17.8784C25.4495 15.7861 24.6171 13.7803 23.1376 12.3008C21.6582 10.8214 19.6524 9.98899 17.5601 9.98626ZM17.5601 23.7118C16.4063 23.7118 15.2785 23.3696 14.3192 22.7287C13.3599 22.0877 12.6123 21.1766 12.1708 20.1107C11.7293 19.0448 11.6137 17.8719 11.8388 16.7404C12.0639 15.6088 12.6195 14.5694 13.4353 13.7536C14.2511 12.9378 15.2905 12.3823 16.422 12.1572C17.5536 11.9321 18.7265 12.0476 19.7924 12.4891C20.8583 12.9306 21.7693 13.6783 22.4103 14.6376C23.0513 15.5969 23.3934 16.7247 23.3934 17.8784C23.3934 19.4255 22.7788 20.9092 21.6848 22.0032C20.5909 23.0972 19.1072 23.7118 17.5601 23.7118ZM25.7954 0.378418H9.32476C6.86845 0.381143 4.51352 1.35812 2.77664 3.095C1.03976 4.83188 0.0627833 7.18681 0.0600586 9.64312V26.1137C0.0627833 28.57 1.03976 30.925 2.77664 32.6618C4.51352 34.3987 6.86845 35.3757 9.32476 35.3784H25.7954C28.2517 35.3757 30.6066 34.3987 32.3435 32.6618C34.0804 30.925 35.0573 28.57 35.0601 26.1137V9.64312C35.0573 7.18681 34.0804 4.83188 32.3435 3.095C30.6066 1.35812 28.2517 0.381143 25.7954 0.378418ZM33.0012 26.1137C33.0012 28.0248 32.242 29.8577 30.8907 31.209C29.5393 32.5604 27.7065 33.3196 25.7954 33.3196H9.32476C7.41365 33.3196 5.5808 32.5604 4.22944 31.209C2.87807 29.8577 2.11888 28.0248 2.11888 26.1137V9.64312C2.11888 7.73201 2.87807 5.89916 4.22944 4.5478C5.5808 3.19643 7.41365 2.43724 9.32476 2.43724H25.7954C27.7065 2.43724 29.5393 3.19643 30.8907 4.5478C32.242 5.89916 33.0012 7.73201 33.0012 9.64312V26.1137ZM28.1973 8.95685C28.1973 9.29618 28.0967 9.62789 27.9082 9.91003C27.7196 10.1922 27.4517 10.4121 27.1382 10.5419C26.8247 10.6718 26.4797 10.7058 26.1469 10.6396C25.8141 10.5734 25.5084 10.41 25.2685 10.17C25.0285 9.93008 24.8651 9.62437 24.7989 9.29156C24.7327 8.95875 24.7667 8.61379 24.8965 8.30028C25.0264 7.98678 25.2463 7.71883 25.5284 7.53031C25.8106 7.34179 26.1423 7.24116 26.4816 7.24116C26.9367 7.24116 27.373 7.42192 27.6948 7.74368C28.0166 8.06543 28.1973 8.50182 28.1973 8.95685Z" fill="#777777"/>
                </svg>
                </a>
            <?php endif; ?>
            <?php if($footer?->facebook): ?>
                <a href="<?php echo e($footer->facebook); ?>" target="_blank" style="color:#fff; font-size:22px;">
                    <svg width="36" height="37" viewBox="0 0 36 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.0001 0.938477C14.4519 0.938477 10.9834 1.99064 8.03313 3.96191C5.08292 5.93318 2.7835 8.73503 1.42567 12.0131C0.0678314 15.2912 -0.28744 18.8984 0.404779 22.3784C1.097 25.8584 2.80562 29.055 5.31457 31.564C7.82352 34.0729 11.0201 35.7815 14.5001 36.4738C17.9802 37.166 21.5873 36.8107 24.8654 35.4529C28.1435 34.095 30.9454 31.7956 32.9166 28.8454C34.8879 25.8952 35.9401 22.4267 35.9401 18.8785C35.9345 14.1222 34.0426 9.56234 30.6794 6.19915C27.3162 2.83596 22.7563 0.944062 18.0001 0.938477ZM19.0554 34.6727V22.7479H23.6283C23.9082 22.7479 24.1766 22.6367 24.3745 22.4388C24.5724 22.2409 24.6836 21.9725 24.6836 21.6926C24.6836 21.4127 24.5724 21.1443 24.3745 20.9464C24.1766 20.7485 23.9082 20.6373 23.6283 20.6373H19.0554V16.0644C19.0554 15.2247 19.3889 14.4195 19.9826 13.8257C20.5763 13.232 21.3816 12.8985 22.2212 12.8985H25.0354C25.3152 12.8985 25.5837 12.7873 25.7816 12.5894C25.9795 12.3915 26.0907 12.1231 26.0907 11.8432C26.0907 11.5633 25.9795 11.2949 25.7816 11.097C25.5837 10.8991 25.3152 10.7879 25.0354 10.7879H22.2212C20.8218 10.7879 19.4797 11.3438 18.4902 12.3333C17.5007 13.3229 16.9448 14.6649 16.9448 16.0644V20.6373H12.3718C12.0919 20.6373 11.8235 20.7485 11.6256 20.9464C11.4277 21.1443 11.3165 21.4127 11.3165 21.6926C11.3165 21.9725 11.4277 22.2409 11.6256 22.4388C11.8235 22.6367 12.0919 22.7479 12.3718 22.7479H16.9448V34.6727C12.8471 34.3989 9.01623 32.5433 6.26115 29.4977C3.50608 26.4522 2.04249 22.4551 2.17946 18.3506C2.31643 14.246 4.04324 10.3554 6.99522 7.50031C9.9472 4.64519 13.8933 3.0491 18.0001 3.0491C22.1069 3.0491 26.0529 4.64519 29.0049 7.50031C31.9569 10.3554 33.6837 14.246 33.8207 18.3506C33.9576 22.4551 32.494 26.4522 29.739 29.4977C26.9839 32.5433 23.153 34.3989 19.0554 34.6727Z" fill="#777777"/>
                    </svg>
                </a>
            <?php endif; ?>
                </div>
            </div>
        </div>
        <div style="flex:1; min-width:180px;">
            <h4 style="font-size:20px; font-weight:bold; margin-bottom:15px;">Help</h4>
            <?php if(!empty($footer?->help_links)): ?>
                <ul style="list-style:none; padding:0; margin:0;">
                    <?php $__currentLoopData = $footer->help_links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li style="margin-bottom:10px;">
                            <a href="<?php echo e($link['url']); ?>" style="color:#fff; text-decoration:none;"><?php echo e($link['title']); ?></a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        </div>
        <div style="flex:1; min-width:220px;">
            <h4 style="font-size:20px; font-weight:bold; margin-bottom:15px;">Important Information</h4>
            <?php if(!empty($footer?->important_links)): ?>
                <ul style="list-style:none; padding:0; margin:0;">
                    <?php $__currentLoopData = $footer->important_links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li style="margin-bottom:10px;">
                            <a href="<?php echo e($link['url']); ?>" style="color:#fff; text-decoration:none;"><?php echo e($link['title']); ?></a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        </div>
        <div style="flex:1; min-width:220px;">
            <h4 style="font-size:20px; font-weight:bold; margin-bottom:15px;">Contacts</h4>
            <div style="margin-bottom: 10px;display: flex;gap: 10px;">
                <svg width="40" height="32" viewBox="0 0 22 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 6.5C10.0729 6.5 9.16662 6.77492 8.39576 7.28999C7.62491 7.80506 7.0241 8.53714 6.66931 9.39367C6.31453 10.2502 6.2217 11.1927 6.40257 12.102C6.58344 13.0113 7.02988 13.8465 7.68544 14.5021C8.341 15.1576 9.17623 15.6041 10.0855 15.7849C10.9948 15.9658 11.9373 15.873 12.7938 15.5182C13.6504 15.1634 14.3824 14.5626 14.8975 13.7917C15.4126 13.0209 15.6875 12.1146 15.6875 11.1875C15.6875 9.9443 15.1936 8.75201 14.3146 7.87294C13.4355 6.99386 12.2432 6.5 11 6.5ZM11 14C10.4437 14 9.89997 13.835 9.43746 13.526C8.97495 13.217 8.61446 12.7777 8.40159 12.2638C8.18872 11.7499 8.13302 11.1844 8.24154 10.6388C8.35006 10.0932 8.61793 9.5921 9.01126 9.19876C9.4046 8.80543 9.90574 8.53756 10.4513 8.42904C10.9969 8.32052 11.5624 8.37622 12.0763 8.58909C12.5902 8.80196 13.0295 9.16245 13.3385 9.62496C13.6476 10.0875 13.8125 10.6312 13.8125 11.1875C13.8125 11.9334 13.5162 12.6488 12.9887 13.1762C12.4613 13.7037 11.7459 14 11 14ZM11 0.875C8.26591 0.878102 5.64468 1.96559 3.71139 3.89889C1.77809 5.83218 0.690602 8.45341 0.6875 11.1875C0.6875 14.8672 2.38789 18.7672 5.60938 22.4668C7.05691 24.1385 8.68608 25.6439 10.4668 26.9551C10.6244 27.0655 10.8122 27.1247 11.0047 27.1247C11.1971 27.1247 11.3849 27.0655 11.5426 26.9551C13.32 25.6434 14.946 24.138 16.3906 22.4668C19.6074 18.7672 21.3125 14.8672 21.3125 11.1875C21.3094 8.45341 20.2219 5.83218 18.2886 3.89889C16.3553 1.96559 13.7341 0.878102 11 0.875ZM11 25.0156C9.06289 23.4922 2.5625 17.8965 2.5625 11.1875C2.5625 8.94974 3.45145 6.80362 5.03379 5.22129C6.61612 3.63895 8.76224 2.75 11 2.75C13.2378 2.75 15.3839 3.63895 16.9662 5.22129C18.5486 6.80362 19.4375 8.94974 19.4375 11.1875C19.4375 17.8941 12.9371 23.4922 11 25.0156Z" fill="#777777"/>
                </svg>
                <a href="https://www.google.com/maps/search/?api=1&query=<?php echo e(urlencode($footer?->contact_address)); ?>" target="_blank" style="color:#fff; text-decoration:none;">
                    <?php echo e($footer?->contact_address); ?>

                </a>
            </div>
            <div style="margin-bottom: 10px;display: flex;gap: 10px;">
                <svg width="40" height="32" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20.625 1.875H9.375C8.62908 1.875 7.91371 2.17132 7.38626 2.69876C6.85882 3.22621 6.5625 3.94158 6.5625 4.6875V25.3125C6.5625 26.0584 6.85882 26.7738 7.38626 27.3012C7.91371 27.8287 8.62908 28.125 9.375 28.125H20.625C21.3709 28.125 22.0863 27.8287 22.6137 27.3012C23.1412 26.7738 23.4375 26.0584 23.4375 25.3125V4.6875C23.4375 3.94158 23.1412 3.22621 22.6137 2.69876C22.0863 2.17132 21.3709 1.875 20.625 1.875ZM21.5625 25.3125C21.5625 25.5611 21.4637 25.7996 21.2879 25.9754C21.1121 26.1512 20.8736 26.25 20.625 26.25H9.375C9.12636 26.25 8.8879 26.1512 8.71209 25.9754C8.53627 25.7996 8.4375 25.5611 8.4375 25.3125V4.6875C8.4375 4.43886 8.53627 4.2004 8.71209 4.02459C8.8879 3.84877 9.12636 3.75 9.375 3.75H20.625C20.8736 3.75 21.1121 3.84877 21.2879 4.02459C21.4637 4.2004 21.5625 4.43886 21.5625 4.6875V25.3125ZM16.4062 7.03125C16.4062 7.30938 16.3238 7.58126 16.1693 7.81252C16.0147 8.04378 15.7951 8.22402 15.5381 8.33046C15.2812 8.43689 14.9984 8.46474 14.7257 8.41048C14.4529 8.35622 14.2023 8.22229 14.0056 8.02562C13.809 7.82895 13.675 7.57838 13.6208 7.3056C13.5665 7.03281 13.5944 6.75006 13.7008 6.4931C13.8072 6.23614 13.9875 6.01652 14.2187 5.862C14.45 5.70748 14.7219 5.625 15 5.625C15.373 5.625 15.7306 5.77316 15.9944 6.03688C16.2581 6.3006 16.4062 6.65829 16.4062 7.03125Z" fill="#777777"/>
                </svg>
                <a href="tel:<?php echo e($footer?->contact_phone); ?>" style="color:#fff; text-decoration:none;">
                    <?php echo e($footer?->contact_phone); ?>

                </a>
            </div>
            <div style="margin-bottom: 10px;display: flex;gap: 10px;">
                <svg width="40" height="32" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M26.25 5.85938H3.75C3.56352 5.85938 3.38468 5.93345 3.25282 6.06532C3.12095 6.19718 3.04688 6.37602 3.04688 6.5625V22.5C3.04688 22.9351 3.21973 23.3524 3.5274 23.6601C3.83508 23.9678 4.25238 24.1406 4.6875 24.1406H25.3125C25.7476 24.1406 26.1649 23.9678 26.4726 23.6601C26.7803 23.3524 26.9531 22.9351 26.9531 22.5V6.5625C26.9531 6.37602 26.879 6.19718 26.7472 6.06532C26.6153 5.93345 26.4365 5.85938 26.25 5.85938ZM15 15.9211L5.55703 7.26562H24.443L15 15.9211ZM11.9145 15L4.45312 21.8391V8.16094L11.9145 15ZM12.9551 15.9539L14.5312 17.393C14.6609 17.5116 14.8302 17.5773 15.0059 17.5773C15.1815 17.5773 15.3509 17.5116 15.4805 17.393L17.0508 15.9539L24.443 22.7344H5.5582L12.9551 15.9539ZM18.0855 15L25.5469 8.16094V21.8391L18.0855 15Z" fill="#777777"/>
                </svg>
                <a href="mailto:<?php echo e($footer?->contact_email); ?>" style="color:#fff; text-decoration:none;">
                    <?php echo e($footer?->contact_email); ?>

                </a>
            </div>
        </div>
    </div>
    <div style="border-top:1px solid #444; margin-top:30px; padding:15px 0 10px 0; max-width:1750px; margin-left:auto; margin-right:auto; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap;">
        <div>
            <a href="/privacy-policy" style="color:#fff;">Privacy & Policy</a>
        </div>
        <div style="text-align:center; flex:1;">
            <?php echo e($footer?->copyright_text); ?>

        </div>
        <div style="display:flex; gap:8px;">
            <span style="display:inline-block; width:32px; height:20px; background:#fff; border-radius:3px; padding:2px;">
                <svg viewBox="0 0 32 20" width="28" height="16" style="vertical-align:middle;">
                    <image href="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" width="32" height="20"/>
                </svg>
            </span>
            <span style="display:inline-block; width:32px; height:20px; background:#fff; border-radius:3px; padding:2px;">
                <svg viewBox="0 0 32 20" width="28" height="16" style="vertical-align:middle;">
                    <image href="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" width="32" height="20"/>
                </svg>
            </span>
            <span style="display:inline-block; width:32px; height:20px; background:#fff; border-radius:3px; padding:2px;">
                <svg viewBox="0 0 32 20" width="28" height="16" style="vertical-align:middle;">
                    <image href="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" width="32" height="20"/>
                </svg>
            </span>
            <span style="display:inline-block; width:32px; height:20px; background:#fff; border-radius:3px; padding:2px;">
                <svg viewBox="0 0 32 20" width="28" height="16" style="vertical-align:middle;">
                    <image href="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" width="32" height="20"/>
                </svg>
            </span>
            <span style="display:inline-block; width:32px; height:20px; background:#fff; border-radius:3px; padding:2px;">
                <svg viewBox="0 0 32 20" width="28" height="16" style="vertical-align:middle;">
                    <image href="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" width="32" height="20"/>
                </svg>
            </span>
            <span style="display:inline-block; width:32px; height:20px; background:#fff; border-radius:3px; padding:2px;">
                <svg viewBox="0 0 32 20" width="28" height="16" style="vertical-align:middle;">
                    <image href="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" width="32" height="20"/>
                </svg>
            </span>
        </div>
    </div>
</footer>

<?php echo view_render_event('bagisto.shop.layout.footer.after'); ?>

<?php /**PATH C:\xampp\htdocs\backendbagisto\thamescc-backend\packages\Webkul\Shop\src/resources/views/components/layouts/footer/index.blade.php ENDPATH**/ ?>