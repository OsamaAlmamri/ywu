<template>
    <div class="d-flex justify-content-end"
        :class="[{'show':(is_active)}]">
        <button type="button"
                @click="is_active = !is_active"

                 class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary dropdown-toggle "
        data-toggle="dropdown">
            <span class="fs-3">...</span>
        </button>

<!--        <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" >-->
<!--            <i class="bi bi-three-dots fs-3"></i>-->
<!--        </button>-->
        <div class="dropdown-menu"
             :class="['dropdown-menu',{'dropdown_animation':(is_active)},{'show':(is_active)}]">
            <slot name="items"></slot>

        </div>
    </div>


<!--    <div class="me-0">-->
<!--        <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">-->
<!--            <i class="bi bi-three-dots fs-3"></i>-->
<!--        </button>-->
<!--        &lt;!&ndash;begin::Menu 3&ndash;&gt;-->
<!--        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true" style="">-->
<!--            &lt;!&ndash;begin::Heading&ndash;&gt;-->
<!--            <div class="menu-item px-3">-->
<!--                <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Payments</div>-->
<!--            </div>-->
<!--            &lt;!&ndash;end::Heading&ndash;&gt;-->
<!--            &lt;!&ndash;begin::Menu item&ndash;&gt;-->
<!--            <div class="menu-item px-3">-->
<!--                <a href="#" class="menu-link px-3">Create Invoice</a>-->
<!--            </div>-->
<!--            &lt;!&ndash;end::Menu item&ndash;&gt;-->
<!--            &lt;!&ndash;begin::Menu item&ndash;&gt;-->
<!--            <div class="menu-item px-3">-->
<!--                <a href="#" class="menu-link flex-stack px-3">Create Payment-->
<!--                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Specify a target name for future usage and reference" aria-label="Specify a target name for future usage and reference"></i></a>-->
<!--            </div>-->
<!--            &lt;!&ndash;end::Menu item&ndash;&gt;-->
<!--            &lt;!&ndash;begin::Menu item&ndash;&gt;-->
<!--            <div class="menu-item px-3">-->
<!--                <a href="#" class="menu-link px-3">Generate Bill</a>-->
<!--            </div>-->
<!--            &lt;!&ndash;end::Menu item&ndash;&gt;-->
<!--            &lt;!&ndash;begin::Menu item&ndash;&gt;-->
<!--            <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">-->
<!--                <a href="#" class="menu-link px-3">-->
<!--                    <span class="menu-title">Subscription</span>-->
<!--                    <span class="menu-arrow"></span>-->
<!--                </a>-->
<!--                &lt;!&ndash;begin::Menu sub&ndash;&gt;-->
<!--                <div class="menu-sub menu-sub-dropdown w-175px py-4">-->
<!--                    &lt;!&ndash;begin::Menu item&ndash;&gt;-->
<!--                    <div class="menu-item px-3">-->
<!--                        <a href="#" class="menu-link px-3">Plans</a>-->
<!--                    </div>-->
<!--                    &lt;!&ndash;end::Menu item&ndash;&gt;-->
<!--                    &lt;!&ndash;begin::Menu item&ndash;&gt;-->
<!--                    <div class="menu-item px-3">-->
<!--                        <a href="#" class="menu-link px-3">Billing</a>-->
<!--                    </div>-->
<!--                    &lt;!&ndash;end::Menu item&ndash;&gt;-->
<!--                    &lt;!&ndash;begin::Menu item&ndash;&gt;-->
<!--                    <div class="menu-item px-3">-->
<!--                        <a href="#" class="menu-link px-3">Statements</a>-->
<!--                    </div>-->
<!--                    &lt;!&ndash;end::Menu item&ndash;&gt;-->
<!--                    &lt;!&ndash;begin::Menu separator&ndash;&gt;-->
<!--                    <div class="separator my-2"></div>-->
<!--                    &lt;!&ndash;end::Menu separator&ndash;&gt;-->
<!--                    &lt;!&ndash;begin::Menu item&ndash;&gt;-->
<!--                    <div class="menu-item px-3">-->
<!--                        <div class="menu-content px-3">-->
<!--                            &lt;!&ndash;begin::Switch&ndash;&gt;-->
<!--                            <label class="form-check form-switch form-check-custom form-check-solid">-->
<!--                                &lt;!&ndash;begin::Input&ndash;&gt;-->
<!--                                <input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications">-->
<!--                                &lt;!&ndash;end::Input&ndash;&gt;-->
<!--                                &lt;!&ndash;end::Label&ndash;&gt;-->
<!--                                <span class="form-check-label text-muted fs-6">Recuring</span>-->
<!--                                &lt;!&ndash;end::Label&ndash;&gt;-->
<!--                            </label>-->
<!--                            &lt;!&ndash;end::Switch&ndash;&gt;-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    &lt;!&ndash;end::Menu item&ndash;&gt;-->
<!--                </div>-->
<!--                &lt;!&ndash;end::Menu sub&ndash;&gt;-->
<!--            </div>-->
<!--            &lt;!&ndash;end::Menu item&ndash;&gt;-->
<!--            &lt;!&ndash;begin::Menu item&ndash;&gt;-->
<!--            <div class="menu-item px-3 my-1">-->
<!--                <a href="#" class="menu-link px-3">Settings</a>-->
<!--            </div>-->
<!--            &lt;!&ndash;end::Menu item&ndash;&gt;-->
<!--        </div>-->
<!--        &lt;!&ndash;end::Menu 3&ndash;&gt;-->
<!--    </div>-->
</template>

<script>

    export default {
        props: {
            is_active_dropdown: {default: false, type: Boolean},

        },
        data() {
            return {
                is_active: false,

            }
        },
        created() {
            this.is_active=this.is_active_dropdown;
        },


    }
</script>
