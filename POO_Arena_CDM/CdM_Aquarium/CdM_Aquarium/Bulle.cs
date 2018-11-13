/*
 * Auteur : Dylan Schito, Kilian Perisset
 * Date : 02.10.2018
 * Projet : Cité des métiers
 * Description : Classe définissant les propriétés et les méthodes d'une bulle 
                 > Gain d'une bulle (expansion lors d'un croisement)
                 > Couleur
                 > Gestion physique (explosion, etc.)
 */

using System.Drawing;
using System.Windows.Forms;

namespace CdM_Aquarium
{
    class Bulle : FormeAnimee
    {
        #region Constantes
        // Constantes contenant le gain pour chaque expansion de bulle (gonfler)
        const int VALEUR_GAIN_BULLE_X = 5;
        const int VALEUR_GAIN_BULLE_Y = 5;
        #endregion


        #region Champs
        // Variable permettant d'acceder à la couleur de la bulle
        private Color _color;
        // Variable permettant de changer l'état de la bulle.
        private bool _explose;
        // Variable permettant de déterminer le scénario actuel
        private bool _change;
        #endregion

        #region Propriétés
        public Color Color { get => _color; set => _color = value; }
        public bool Explose { get => _explose; set => _explose = value; }
        public bool Change { get => _change; set => _change = value; }

        #endregion

        #region Constructeurs
        public Bulle(PointF pDebut, PointF pFin, double largeur, double hauteur, double vitesse)
            : base(pDebut, pFin, largeur, hauteur, vitesse)
        {
            this.Change = false;
            this.Explose = false;
        }
        public Bulle(PointF pDebut, PointF pFin)
            : base(pDebut, pFin, 10, 10, 3000)
        {
        }

        public Bulle()
            : this(new PointF(100, 0), new PointF(100, 100))
        {
        }
        #endregion

        #region Méthodes

        /// <summary>
        /// Permet de gonfler une bulle avec la taille de gain prédéfinie
        /// </summary>
        public void Gonfler()
        {
            this.GrandirForme(VALEUR_GAIN_BULLE_X, VALEUR_GAIN_BULLE_Y);
        }

        /// <summary>
        /// Lors de l'affichage de la bulle
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        public override void Paint(object sender, PaintEventArgs e)
        {
            Pen myPen = new Pen(Color.Red, 4);

            if (!this.Change)
                e.Graphics.FillEllipse(new SolidBrush(Color.LightBlue), this.BoiteDeCollision);
            else
                e.Graphics.DrawEllipse(myPen, this.BoiteDeCollision);
        }
        #endregion
    }
}
