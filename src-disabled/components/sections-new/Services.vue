<template>

    <section class="pt-45px pb-25px bg-dark">
        <div class="container container-full">
            <a href="#" class="serv-item">
                <i class="fa     fa-heart"></i>
                Tickets reserve
            </a>
            <a href="#" class="serv-item">
                <i class="fa     fa-heart"></i>
                music fests
            </a>
            <a href="#" class="serv-item">
                <i class="fa     fa-heart"></i>
                fast support
            </a>
            <a href="#" class="serv-item">
                <i class="fa     fa-heart"></i>
                Secure Payments
            </a>
            <a href="#" class="serv-item">
                <i class="fa     fa-heart"></i>
                Easy to return
            </a>
        </div>
    </section>


</template>

<style scoped lang="scss">
.serv-item {
    color: white;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 15px;
    border-style: solid;
    border-width: 0 0 0 0;

    border-color: #FFF;
    transition: background 0.3s, border 0.3s, border-radius 0.3s, box-shadow 0.3s;
    margin: 0px 0px 20px 0px;
    width: 100%;
    margin-bottom: 20px;

    @include media-breakpoint-up(md) {
        width: 50% !important;

        &:nth-of-type(1),
        &:nth-of-type(3) {
            border-width: 0 1px 0 0;
        }

        &:last-of-type {
            width: 100% !important;
        }
    }

    @include media-breakpoint-up(lg) {
        width: 20% !important;
        border-width: 0 1px 0 0;

        &:last-of-type {
            width: 20% !important;
            border-width: 0 0 0 0;
        }
    }

    i {
        font-size: 30px;
        margin-right: 20px;
        color: white;
        transition: all .3s;
    }

    &:hover {
        i {
            color: var(--primary);
        }
    }
}
</style>