/*
  * Auteurs : Brunazzi Robin, Dylan Schito, Kilian Périsset
  * Date : 18.09.2018
  * Projet : Cité des métiers
  * Description : Classe définissant les propriétés et les méthodes d'un poisson 
                 > Forme du poisson
                 > Direction du poisson (gauche-droite ou droite-gauche)
                 > Vélocité du poisson
  */

using System;
using System.Drawing;
using System.Windows.Forms;

namespace CdM_Aquarium
{
    class Poisson : FormeAnimee
    {
        int _sensPoisson;
        Pen _myPen;
        private bool _change;
        public int SensPoisson { get => _sensPoisson; set => _sensPoisson = value; }
        public Pen MyPen { get => _myPen; set => _myPen = value; }
        public bool Change { get => _change; set => _change = value; }


        #region Constructeurs

            /// <summary>
            /// Constructeur d'un poisson, en donnant un point de départ et un point d'arrivée
            /// </summary>
            /// <param name="pDebut">Point de départ (coordonnées)</param>
            /// <param name="pFin">Point d'arrivée (coordonnées)</param>
        public Poisson(PointF pDebut, PointF pFin) :
            base(pDebut, pFin)
        {
            if (pDebut.X < pFin.X)
                this.SensPoisson = 1;
            else
                this.SensPoisson = -1;
        }

        /// <summary>
        /// Constructeur d'un poisson complet
        /// </summary>
        /// <param name="pDebut">Point de départ</param>
        /// <param name="pFin">Point d'arrivée</param>
        /// <param name="pLargeur">Largeur de la forme</param>
        /// <param name="pHauteur">Hauteur de la forme</param>
        /// <param name="pVitesse">Vélocité/Vitesse</param>
        public Poisson(PointF pDebut, PointF pFin, double pLargeur, double pHauteur, double pVitesse) :
            base(pDebut, pFin, pLargeur, pHauteur, pVitesse)
        {
            if (pDebut.X < pFin.X)
                this.SensPoisson = 1;
            else
                this.SensPoisson = -1;
        }
        #endregion

        #region Méthodes
        public override void Paint(object sender, PaintEventArgs e)
        {
        }

        /// <summary>
        /// Dessine un poisson sur la base d'une image (dysfonctionnel)
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void DessinerPoissonDepuisImage(object sender, PaintEventArgs e)
        {
        }

        /// <summary>
        /// Inverse la direction du poisson (si déplacement de gauche à droite, passe de droite à gauche)
        /// </summary>
        public void ChangerDeSens()
        {
            this.SensPoisson *= -1;
        }
        
        /// <summary>
        /// Génère une "moitié de poisson" courbée sur la base d'un angle Teta
        /// </summary>
        /// <param name="t">Teta (angle de courbure de la forme)</param>
        /// <returns></returns>
        public PointF CourbePoisson(double t)
        {
            double x, y;
            x = (this.Hauteur * Math.Cos(t) - this.Hauteur * Math.Sin(t) * Math.Sin(t) / Math.Sqrt(2)) * this.SensPoisson;
            y = (this.Hauteur * Math.Cos(t) * Math.Sin(t));
            return new PointF(Position.X + Convert.ToSingle(x), Position.Y + Convert.ToSingle(y));
        }

        /// Génère un poisson courbé avec fonction paramétrique (mathématiques)
        public void DessinerPoissonDepuisFonction(object sender, PaintEventArgs e)
        {
            this.MyPen = new Pen(Color.FromArgb(255, 255, 69, 0), 8);
            // Si le scénario n'est PAS en version "simplifié" (formes simples)
            if (!this.Change)
            {
                // Permet un dessin plus "affiné"
                e.Graphics.SmoothingMode = System.Drawing.Drawing2D.SmoothingMode.HighQuality;

                double t = 0;
                double deltat = 2.0 * Math.PI / 100.0;
                // "Précision" à 100 lignes 0->99 (le poisson sera composé de 100 traits)
                for (int i = 0; i < 99; i++)
                {
                    // Utilisation de la méthode de courbure déclarée en amont
                    e.Graphics.DrawLine(MyPen, CourbePoisson(t), CourbePoisson(t + deltat));
                    t = t + deltat;
                }
            }
            // Si le scénario est en version simplifié, dessiner de simples traits
            else
            {
                e.Graphics.DrawEllipse(MyPen, (float)this.Position.X, (float)this.Position.Y, 100, 50);
            }
        }
        #endregion
    }
}
