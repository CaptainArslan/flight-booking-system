<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark scrollbar-custom">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"><span class="navbar-toggler-icon"></span></button>
        <a href="<?php echo base_url('dashboard') ?>">
            <h1 class="navbar-brand navbar-brand-autodark">Booking Panel</h1>
        </a>
        <hr class="mb-0 mt-0">
        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    <span class="avatar avatar-sm" style="background-image: url('<?php echo (!file_exists(base_url('assets/images/users/' . $this->user_profile_pic))) ? base_url('assets/images/users/' . $this->user_profile_pic) : base_url('assets/images/users/default.png'); ?>')"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div><?php echo $this->user_name; ?></div>
                        <div class="mt-1 small text-muted"><small><?php echo $this->user_email; ?></small></div>
                        <div class="mt-1 small text-muted"><small><?php echo $this->user_role; ?></small></div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a class="dropdown-item" href="<?php echo base_url('user/profile/' . hashing($this->user_profile_id)); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        Account Settings
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo base_url("logout"); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg> Logout
                    </a>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <!-- <ul class="navbar-nav pt-lg-3">
                <?php
                foreach ($this->navs as $key => $nav) {
                    if (checkAccess($this->session->userdata('user_role'), $nav['access'])) {
                ?>
                <li class="nav-item <?php echo ($nav['is_active'] && $nav['subnav']) ? 'active ' : '';
                                    echo ($nav['subnav']) ? ' dropdown' : ''; ?>">
                    <a class="nav-link <?php echo ($nav['subnav']) ? 'dropdown-toggle ' : '';
                                        echo ($nav['is_active']) ? ' active' : '';
                                        echo ($nav['is_active'] && $nav['subnav']) ? ' show' : ''; ?>" href="<?php echo ($nav['href']) ? $nav['href'] : 'javascript:void(0)" data-bs-toggle="dropdown'; ?>" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block"><?php echo $nav['icon']; ?></span><span class="nav-link-title"><?php echo $nav['title']; ?></span>
                    </a>
                    <?php if ($nav['subnav']) { ?>
                        <div class="dropdown-menu <?php echo ($nav['is_active'] && $nav['subnav']) ? 'show' : ''; ?>">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <?php
                                    foreach ($nav['subnav'] as $key => $subnav) {
                                        if (checkAccess($this->session->userdata('user_role'), $subnav['access'])) {
                                    ?>
                                        <a class="dropdown-item <?php echo ($subnav['is_active']) ? 'active' : ''; ?>" href="<?php echo $subnav['href']; ?>"><?php echo $subnav['title']; ?></a>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </li>
                <?php
                    }
                }
                ?>
            </ul> -->
            <ul class="navbar-nav pt-lg-3">
                <?php foreach ($this->navs as $key => $nav) : ?>
                    <?php if (checkAccess($this->session->userdata('user_role'), $nav['access'])) : ?>
                        <li class="nav-item <?php echo ($nav['is_active']) ? ' active' : ''; ?>">
                            <a class="nav-link pt-1 pb-1 <?php echo ($nav['subnav']) ? ' sidebardivider' : ''; ?>" href="<?php echo ($nav['href']) ? $nav['href'] : 'javascript:void(0)'; ?>">
                                <span class="nav-link-icon d-md-none d-lg-inline-block"><?php echo $nav['icon']; ?></span>
                                <span class="nav-link-title">
                                    <?php echo $nav['title']; ?>
                                    <?php if ($nav['count']) : ?>
                                        <span class="m-2 badge rounded-pill bg-danger"><?php echo $nav['count']; ?></span>
                                    <?php endif; ?>
                                </span>
                            </a>
                            <?php if ($nav['subnav']) : ?>
                                <ul class="dropdown-menu show">
                                    <?php foreach ($nav['subnav'] as $subnav) : ?>
                                        <?php if (checkAccess($this->session->userdata('user_role'), $subnav['access'])) : ?>
                                            <li class="<?php echo ($subnav['is_active']) ? 'active' : ''; ?>">
                                                <a class="pt-1 pb-1 dropdown-item <?php echo ($subnav['is_active']) ? 'active' : ''; ?>" href="<?php echo $subnav['href']; ?>" style="padding-left: 2.25rem !important;">
                                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><?php echo $subnav['icon']; ?></span>
                                                    <span class="nav-link-title"><?php echo $subnav['title']; ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>

        </div>
    </div>
</aside>