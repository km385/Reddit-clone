<template>
    <div class="max-w-[700px] rounded-xl">

        <div class="rounded-r-md grow flex flex-col *:mx-4">
            <div class="text-sm mt-2 flex items-center gap-1 ">
                <p class="text-white hover:text-text-blue cursor-pointer">r/shitposting</p>
                <p class="text-gray-400 grow">&#x2022; 5 hours ago</p>
                <ContextMenu />
            </div>
            <div class="text-white text-xl">Mam dosyć</div>
            <div class="">
                <p class="line-clamp-[6] text-white">
                    Mam 26 lat. Magistra na karku. Do wczoraj marzenia. Tyle lat nauki, podczas studiów dodatkowe kursy.
                    Cały czas się rozwijam i douczam. Na samym początku kariery trafiłam na bardzo toksyczne miejsce gdzie
                    każdy starał się zgnoić młodego a druga połowa udawała że nie istnieje. Rzuciłam tą pracę bo nie dawałam
                    rady psychicznie, zaczęły się napady paniki, sraczki i rzyganie na samą myśl o pracy. Potem starałam się
                    dostać pracę wszędzie. Nie tylko w zawodzie. Na biedronki i sklepy mam za wysokie wykształcenie i to
                    jeszcze nie w takim kierunku co by chcieli. Na jakieś pomoce nauczyciela w przedszkolach również (mimo
                    że mam tu doświadczenie) cytat "bo gdzie pani ze swoimi studiami będzie pupy podcierać dzieciom".
                    Składałam CV do prac wszędzie i chyba do każdej firmy w moim mieście. Jedynie gdzie wybrzydzam to praca
                    fizyczna (również ze względów złych pleców) no i seks praca. Jestem wykształconą osobą. Poszerzającą
                    swoją wiedzę a kurwa od 4 miesięcy nie mogę znaleźć pracy. Przerasta mnie to. Nie wiem co mam robić.
                    Chodzenie do firm. Pisanie maili i dzwonienie nawet jak nie szukają nie pomaga. Od kilku miesięcy
                    wszystko co mogło pójść źle idzie źle. Nie wiem co mam dalej robić
                </p>
            </div>
            <post-controls/>
        </div>

    </div>
</template>
<script setup lang="ts">
import PostControls from "@/components/post/PostControls.vue";
import ContextMenu from "@/components/post/ContextMenu.vue";
</script>