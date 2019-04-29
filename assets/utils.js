const utils = {
  getSeoData: function(slug) {
    const seoData = [
      {
        slug: 'veoteenus',
        desc:
          'Veoteenused juhuks kui on vaja transportida midagi punktist A punkti B. Pakume veoteenuseid Tallinnas, Tartus ja üle terve Eesti.',
        title: 'Veoteenus | OK Movers - Kolimine, Transport, Ladustamine'
      },
      {
        slug: 'pakkimine',
        desc:
          'Kaitse oma vara tellides professionaalne pakkimine meilt. Tagame alati teie vara turvalise pakkimise ja kolimise.',
        title: 'Pakkimine | OK Movers – Kolimine, Transport, Ladustamine'
      },
      {
        slug: 'vana-moobli-transport-ja-utiliseerimine',
        desc:
          'Utiliseerime ja transpordime vana mööblit ning teostame kodumasinate äravedu. Utiliseerime vastavalt soovile kas ühe eseme või terve korteri mööbli kaupa.',
        title: 'Vana mööbli transport ja utiliseerimine | OK Movers'
      },
      {
        slug: 'raskete-asjade-transport',
        desc:
          'Seifide, klaverite ja muude raskete esemete transport, tõsted ja paigaldamine, seda kiirelt ja kvaliteetselt. Vali pikaajalised kogemused ja kolimisvaldkonna tippspetsialistid.',
        title: 'Raskete asjade transport | OK Movers'
      },
      {
        slug: 'kolimisteenused-erakliendile',
        desc:
          'Kolimisteenused sinu kodu kolimiseks oma ala tippudelt. Vali ettevõte kellel on eraisikute kolimisega pikaaegne kogemus ning kes hoolib sinu vara turvalisusest samapalju kui sa ise.',
        title: 'Kolimisteenused erakliendile | OK Movers'
      },
      {
        slug: 'kolimisteenused-ettevotetele',
        desc:
          'Kolime Teie kontori, lao või kauba sihtkohta kiirelt, mugavalt ja turvaliselt. Kui otsid partnerit kolimiseks, siis vali oma ala spetsialistid.',
        title: 'Ettevõtete kolimisteenused | OK Movers'
      },
      {
        slug: 'rahvusvaheline-kolimisteenus',
        desc:
          'OK Movers aitab rahvusvahelisel kolimisel üle terve maailma – alates dokumentide vormistamisest kuni mahalaadimiseni sihtkohas. Vali professionaalne kolimisteenus ning kolimine onmurevaba.',
        title: 'Rahvusvaheline kolimisteenus | OK Movers'
      },
      {
        slug: 'eritransport',
        desc:
          'Pakume masinate, seadmete, erikujuliste ning üldiselt keeruliselt transporditavate esemete transporti ja kolimist. Meil on pikajaline kogemus erivedude valdkonnas ning aitame alati kõigega.',
        title: 'Eritransport | OK Movers - Kolimine, Transport, Ladustamine'
      },
      {
        slug: 'default',
        title: 'Kolimisteenused | OK Movers – Kolimine, Transport, Ladustamine'
      }
    ]
    for (let i = 0; i < seoData.length; i++) {
      if (slug === seoData[i].slug) {
        return seoData[i]
      }
      if (i === 8) {
        return seoData[8]
      }
    }
  }
}

export default utils
