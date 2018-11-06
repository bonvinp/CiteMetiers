/*
 * Auteur : Dylan Schito, Kilian Perisset, Robin Brunazzi
 * Date : 02.10.2018
 * Projet : Cité des métiers
 * Description : Classe définissant les propriétés et les méthodes de l'aquarium 
                 > Génération des objets (bulles, poissons)
                 > Gestion des collisions entre les objets
                 > Définition d'un contexte physique (taille, vélocité, etc.)
 */

using CdM_Aquarium.Properties;
using System;
using System.Collections.Generic;
using System.Drawing;
using System.Windows.Forms;

namespace CdM_Aquarium
{
    class Aquarium
    {
        #region Constantes
        // Constante définissant la hauteur par défaut de l'Aquarium (limite verticale)
        const int HAUTEUR_AQUARIUM = 600;
        // Constante définissant la largeur par défaut de l'Aquarium (limite horizontale)
        const int LARGEUR_AQUARIUM = 900;
        // Constante définissant le nombre de bulles à faire apparaître par "tick" (rotation complète minuterie)
        const int BULLES_PAR_TICK = 10;
        #endregion

        #region Champs
        // Variable contenant un objet "Form", c'est-à-dire l'interface graphique
        private Form _vue;
        // Variable contenant un objet "Minuterie" permettant la génération des bulles, la vérification des collisions, etc.
        private Timer _minuterie;
        // Variable contenant un objet "Minuterie" pour le rafraîchissement de l'interface (tick rate)
        private Timer _rafraichir;
        // Variable contenant un objet "Random" qui permet de générer des nombres aléatoires
        private Random _rnd;
        // Variable contenant la hauteur de l'Aquarium
        private int _hauteurAquarium;
        // Variable contenant la largeur de l'Aquarium
        private int _largeurAquarium;

        // Variable contenant un objet "Liste de bulles" qui contient les bulles affichées à l'écran
        private List<Bulle> _bulles;
        // Variable contenant un objet "Liste de bulles" qui contient les bulles à supprimer au prochain rafraîchissement
        private List<Bulle> _bullesASupprimer;
        // Variable contenant un objet "Liste de bulles" qui contient les bulles à gonfler au prochain rafraîchissement
        private List<Bulle> _bullesAGonfler;

        // Variable contenant un objet "Liste de poissons" qui contient les poissons affichés à l'écran
        private List<Poisson> _poissons;
        #endregion

        #region Propriétés
        /// <summary>
        /// Liste des bulles de l'aquarium
        /// </summary>
        private List<Bulle> Bulles { get => _bulles; set => _bulles = value; }
        private List<Poisson> Poissons { get => _poissons; set => _poissons = value; }
        public int HauteurAquarium { get => _hauteurAquarium; set => _hauteurAquarium = value; }
        public int LargeurAquarium { get => _largeurAquarium; set => _largeurAquarium = value; }
        public Form Vue { get => _vue; set => _vue = value; }
        public Timer Minuterie { get => _minuterie; set => _minuterie = value; }
        public Random Rnd { get => _rnd; set => _rnd = value; }

        /// <summary>
        /// Liste stockant les bulles à supprimer
        /// </summary>
        public List<Bulle> BullesASupprimer { get => _bullesASupprimer; set => _bullesASupprimer = value; }
        internal List<Bulle> BullesAGonfler { get => _bullesAGonfler; set => _bullesAGonfler = value; }
        public Timer Rafraichir { get => _rafraichir; set => _rafraichir = value; }

        #endregion

        #region Méthodes

        #region Consctructeur
        public Aquarium(Form vue)
        {
            // Récupération de la vue (FrmPrincipale)
            this.Vue = vue;

            // Initialisation du rafraichissement (timer)
            this.Rafraichir = new Timer();
            // Chaine de l'évènement de rafraichissement (timer)
            this.Rafraichir.Tick += Refresh_Tick;
            this.Rafraichir.Interval = 40;
            this.Rafraichir.Start();

            // Initialisation du minuteur (timer)
            this.Minuterie = new Timer();
            // Chaine de l'évènement de la minuterie (timer)
            this.Minuterie.Tick += Minuterie_Tick;
            this.Minuterie.Interval = 100;
            this.Minuterie.Start();

            // Chainer l'évènement du click sur la vue
            this.Vue.MouseClick += Vue_MouseClick;
            // Initialisation des variables de classe
            this.HauteurAquarium = HAUTEUR_AQUARIUM;
            this.LargeurAquarium = LARGEUR_AQUARIUM;
            this.Vue.Height = HAUTEUR_AQUARIUM;
            this.Vue.Width = LARGEUR_AQUARIUM;
            this.Vue.BackgroundImage = Resources.aquarium_background;
            this.Vue.BackgroundImageLayout = ImageLayout.Stretch;

            this.Vue.Resize += Vue_Resize;

            this.Rnd = new Random();

            // Initialisation des listes
            this.Bulles = new List<Bulle>();
            this.BullesASupprimer = new List<Bulle>();
            this.BullesAGonfler = new List<Bulle>();

            this.Poissons = new List<Poisson>();
        }

        private void Vue_Resize(object sender, EventArgs e)
        {
            this.HauteurAquarium = this.Vue.Height;
            this.LargeurAquarium = this.Vue.Width;
            List<Poisson> poissonsASupprimer = new List<Poisson>();
            Poissons.ForEach(p =>
            {
                if (p.Position.Y > this.Vue.Height || p.Position.X > this.Vue.Width)
                {
                    poissonsASupprimer.Add(p);
                    this.Vue.Paint -= p.DessinerPoissonDepuisFonction;
                }
            });
            poissonsASupprimer.ForEach(p => this.Poissons.Remove(p));
            poissonsASupprimer.Clear();
        }
        #endregion

        /// <summary>
        /// À chaque "tick" de la minuterie, effectuer une série d'actions (collisions, fusion, inversion du sens)
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void Minuterie_Tick(object sender, EventArgs e)
        {
            // Pour chaque bulle de la liste, "b" représentant une bulle
            Bulles.ForEach(b =>
            {
                DetecteCollision(b);
            });
            FusionBulle();

            // Pour chaque bulle à créer à chaque tick
            for (int i = 0; i < BULLES_PAR_TICK; i++)
            {
                // Créer un nouvel objet "Bulle" avec des coordonnées de destination et d'origine aléatoires
                Bulle maBulle = new Bulle(
              new PointF(this.Rnd.Next(0, this.LargeurAquarium), this.Rnd.Next(this.HauteurAquarium - 100, this.HauteurAquarium)),
              new PointF(this.Rnd.Next(0, this.LargeurAquarium), -10));
                this.Bulles.Add(maBulle);
                this.Vue.Paint += maBulle.Paint;
            }

            // Pour chaque bulle, si celle-ci est arrivée à destination, la faire disparaître de l'interface graphique
            Bulles.ForEach(b => { if (b.estArrive) { this.Vue.Paint -= b.Paint; } });
            // Supprimer toutes les bulles qui sont arrivées de la liste des bulles
            Bulles.RemoveAll(b => b.estArrive);

            Poissons.ForEach(p =>
            {
                if (p.estArrive)
                {
                    p.ChangerDeSens();
                    p.InverserDirection();
                }
            });
        }
        /// <summary>
        /// À chaque "tick" de la minuterie de rafraîchissement
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void Refresh_Tick(object sender, EventArgs e)
        {
            // Vue..Graphics.SmoothingMode = System.Drawing.Drawing2D.SmoothingMode.HighQuality;

            // Réinitialiser l'interface pour qu'elle réaffiche les objets selon leurs coordonnées actuelles
            this.Vue.Invalidate();
        }

        /// <summary>
        /// À chaque clic de la souris sur l'interface graphique (vue)
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void Vue_MouseClick(object sender, MouseEventArgs e)
        {
            // Créer une nouvelle bulle avec des coordonnées aléatoires, puis l'ajoute à la liste des bulles à afficher
            Bulle maBulle = new Bulle(
                new PointF(this.Rnd.Next(0, this.LargeurAquarium), this.Rnd.Next(this.HauteurAquarium - 100, this.HauteurAquarium)),
                new PointF(this.Rnd.Next(0, this.LargeurAquarium), 0));
            this.Bulles.Add(maBulle);
            this.Vue.Paint += maBulle.Paint;

            // Créer un nouveau poisson au niveau de la souris, puis l'ajouter à la la liste des poissons à afficher
            Poisson monPoisson = new Poisson(e.Location, new PointF(50, e.Location.Y), 50, 50, 2500);
            this.Poissons.Add(monPoisson);
            this.Vue.Paint += monPoisson.DessinerPoissonDepuisFonction;
        }

        #region Bulles 
        /// <summary>
        /// Détéction des collisions entre les bulles
        /// </summary>
        /// <param name="bulle1">Objet bulle à tester pour les collisions</param>
        /// <returns>Booléen représentant si une collision est détectée</returns>
        public bool DetecteCollision(Bulle bulle1)
        {
            // Par défaut, on considère qu'il n'y a aucune collision
            bool collision = false;

            // Pour chacune des bulles contenues dans l'aquarium
            this.Bulles.ForEach(bulle2 =>
            {
                // Vérifications d'usage (si les deux bulles vérifiées ne sont pas les mêmes, si elles n'ont pas explosé)
                if ((bulle1 != bulle2) && (!bulle1.Explose) && (!bulle2.Explose) &&
                // Si la boîte de collision de la bulle 1 croise avec celle de la bulle 2, alors :
                (bulle1.BoiteDeCollision.IntersectsWith(bulle2.BoiteDeCollision)))
                {
                    // Gonfler une nouvelle bulle conservant les propriétés de la bulle d'origine, et supprimer l'autre bulle
                    this.BullesAGonfler.Add(bulle1);
                    bulle2.Explose = true;
                    this.BullesASupprimer.Add(bulle2);
                    collision = true;
                    return;
                }
            });
            return collision;
        }

        /// <summary>
        /// Fusionne les bulles
        /// </summary>
        private void FusionBulle()
        {
            // Retire du Paint de la vue les bulles qui vont être supprimées
            this.BullesASupprimer.ForEach(p => this.Vue.Paint -= p.Paint);

            // Supprime les bulles de la liste principale
            this.BullesASupprimer.ForEach(p => Bulles.Remove(p));
            this.BullesASupprimer.Clear();

            // Gonfle les bulles de la liste
            this.BullesAGonfler.ForEach(p => p.Gonfler());
            this.BullesAGonfler.Clear();
        }
        #endregion

        #endregion
    }
}
