<?php echo view_render_event('bagisto.shop.layout.footer.before'); ?>


<?php $themeCustomizationRepository = app('Webkul\Theme\Repositories\ThemeCustomizationRepository'); ?>

<?php
    $footer = \Webkul\Shop\Models\FooterSetting::first();
?>

<footer style="background:rgba(26,26,26,0.6);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px);color:#fff;font-family:inherit;padding:50px 20px 20px 20px;">
    <div style="display:flex;flex-wrap:wrap;gap:40px;justify-content:space-between;max-width:1400px;margin:0 auto;">

        <!-- Logo + About + Socials -->
        <div style="flex:1;min-width:220px;">
            <a href="<?php echo e(route('shop.home.index')); ?>">
                <img src="<?php echo e(core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg')); ?>"
                     alt="<?php echo e(config('app.name')); ?>"
                     style="max-width:150px;height:auto;">
            </a>
            <p style="margin-top:15px;line-height:1.6;opacity:0.9;"><?php echo $footer?->about_text; ?></p>

            <div style="margin-top:15px;display:flex;gap:15px;flex-wrap:wrap;">
                <?php if($footer?->twitter): ?>
                    <a href="<?php echo e($footer->twitter); ?>" target="_blank" style="color:#fff;font-size:20px;transition:0.3s;">
                        <!-- X (Twitter) SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.5 11.24H17.17l-5.292-6.92-6.06 6.92H2.51l7.73-8.82L2 2.25h6.42l4.82 6.41 5.004-6.41z"/>
                        </svg>
                    </a>
                <?php endif; ?>

                <?php if($footer?->instagram): ?>
                    <a href="<?php echo e($footer->instagram); ?>" target="_blank" style="color:#fff;font-size:20px;transition:0.3s;">
                        <!-- Instagram SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7.75 2h8.5C19.1 2 21 3.9 21 6.25v8.5C21 17.1 19.1 19 16.25 19h-8.5C4.9 19 3 17.1 3 14.75v-8.5C3 3.9 4.9 2 7.75 2zm0-2C3.47 0 0 3.47 0 7.75v8.5C0 20.53 3.47 24 7.75 24h8.5C20.53 24 24 20.53 24 16.25v-8.5C24 3.47 20.53 0 16.25 0h-8.5zM12 7a5 5 0 100 10 5 5 0 000-10zm0 2.1a2.9 2.9 0 110 5.8 2.9 2.9 0 010-5.8zM18.4 4.6a1.4 1.4 0 100 2.8 1.4 1.4 0 000-2.8z"/>
                        </svg>
                    </a>
                <?php endif; ?>

                <?php if($footer?->facebook): ?>
                    <a href="<?php echo e($footer->facebook); ?>" target="_blank" style="color:#fff;font-size:20px;transition:0.3s;">
                        <!-- Facebook SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22.675 0h-21.35C.596 0 0 .597 0 1.333v21.333C0 23.403.596 24 1.325 24h11.49v-9.294H9.691V11.01h3.124V8.414c0-3.1 1.894-4.788 4.659-4.788 1.325 0 2.464.098 2.794.142v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.764v2.31h3.587l-.467 3.696h-3.12V24h6.116C23.404 24 24 23.403 24 22.667V1.333C24 .597 23.404 0 22.675 0z"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        

        <!-- Help Links -->
        <div style="flex:1;min-width:180px;">
            <h4 style="font-size:18px;font-weight:600;margin-bottom:15px;border-bottom:1px solid rgba(255,255,255,0.2);padding-bottom:8px;">Help</h4>
            <?php if(!empty($footer?->help_links)): ?>
                <ul style="list-style:none;padding:0;margin:0;">
                    <?php $__currentLoopData = $footer->help_links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li style="margin-bottom:8px;">
                            <a href="<?php echo e($link['url']); ?>" style="color:#fff;text-decoration:none;opacity:0.85;"><?php echo e($link['title']); ?></a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Important Links -->
        <div style="flex:1;min-width:220px;">
            <h4 style="font-size:18px;font-weight:600;margin-bottom:15px;border-bottom:1px solid rgba(255,255,255,0.2);padding-bottom:8px;">Important Information</h4>
            <?php if(!empty($footer?->important_links)): ?>
                <ul style="list-style:none;padding:0;margin:0;">
                    <?php $__currentLoopData = $footer->important_links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li style="margin-bottom:8px;">
                            <a href="<?php echo e($link['url']); ?>" style="color:#fff;text-decoration:none;opacity:0.85;"><?php echo e($link['title']); ?></a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Contacts -->
        <div style="flex:1;min-width:220px;">
            <h4 style="font-size:18px;font-weight:600;margin-bottom:15px;border-bottom:1px solid rgba(255,255,255,0.2);padding-bottom:8px;">Contact</h4>
            <p style="margin-bottom:8px;opacity:0.9;"><?php echo e($footer?->contact_address); ?></p>
            <p style="margin-bottom:8px;opacity:0.9;"><a href="tel:<?php echo e($footer?->contact_phone); ?>" style="color:#fff;text-decoration:none;"><?php echo e($footer?->contact_phone); ?></a></p>
            <p style="margin-bottom:8px;opacity:0.9;"><a href="mailto:<?php echo e($footer?->contact_email); ?>" style="color:#fff;text-decoration:none;"><?php echo e($footer?->contact_email); ?></a></p>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div style="border-top:1px solid rgba(255,255,255,0.15);margin-top:40px;padding-top:20px;display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;gap:15px;font-size:14px;opacity:0.85;text-align:center;">
        <div style="flex:1;"><a href="/privacy-policy" style="color:#fff;text-decoration:none;">Privacy & Policy</a></div>
        <div style="flex:1;"><?php echo e($footer?->copyright_text); ?></div>
        <div style="flex:1;display:flex;justify-content:center;gap:10px;">
            <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="Visa" style="height:20px;background:#fff;border-radius:3px;padding:3px;">
            <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" alt="MasterCard" style="height:20px;background:#fff;border-radius:3px;padding:3px;">
            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal" style="height:20px;background:#fff;border-radius:3px;padding:3px;">
        </div>
    </div>
</footer>

<?php echo view_render_event('bagisto.shop.layout.footer.after'); ?>

<?php /**PATH C:\xampp\htdocs\backendbagisto\thamescc-backend\packages\Webkul\Shop\src/resources/views/components/layouts/footer/index.blade.php ENDPATH**/ ?>