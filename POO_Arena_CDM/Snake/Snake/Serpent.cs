/*************************************************
 * Auteur         : Guillaume Pin
 * Co-Auteur      : Kilian Périsset
 * Nom du fichier : Snake
 * Description    : Jeu du Snake digne du nokia 3310
 * Date           : 22 novembre 2017
 * Version        : 1.0
 * **************************************************/

using System.Collections.Generic;
using System.Drawing;
using System.Windows.Forms;

namespace Snake
{
    class Serpent
    {
        #region Champs
        public Point positionTete = new Point(5,14);
        public List<Point> positioncorps = new List<Point>();
        Point Cellule = new Point();
        int direction;
        int marge;
        int grandir;
        #endregion

        #region Propriété
        public int Longueur
        {
            get
            {
                return positioncorps.Count + 1;
            }
        }
        #endregion

        #region Constructeur
        /// <summary>
        /// Constructeur de la class
        /// </summary>
        /// <param name="NombreCelluleX">Nombre de cellule sur l'axe X</param>
        /// <param name="NombreCelluleY">Nombre de cellule sur l'axe Y</param>
        /// <param name="marge">Marge du jeu</param>
        public Serpent(int NombreCelluleX, int NombreCelluleY, int marge)
        {
            Cellule = new Point(NombreCelluleX, NombreCelluleY);
            this.marge = marge;
            positioncorps.Add(new Point(1,14));
            positioncorps.Add(new Point(2,14));
            positioncorps.Add(new Point(3, 14));
            positioncorps.Add(new Point(4, 14));
        }
        #endregion

        #region Méthode
        /// <summary>
        /// Méthode qui affiche le serpent
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        public void Paint(object sender, PaintEventArgs e)
        {
            // Affiche la tête du serpent
            e.Graphics.FillRectangle(new SolidBrush(Color.Yellow), marge + positionTete.X * Cellule.X, marge + positionTete.Y * Cellule.Y, Cellule.X, Cellule.Y);
            for (int i = 0; i < positioncorps.Count; i++)
                // Affiche le corp du serpent
                e.Graphics.FillRectangle(new SolidBrush(Color.Green), marge + positioncorps[i].X * Cellule.X, marge + positioncorps[i].Y * Cellule.Y, Cellule.X, Cellule.Y);
        }

        /// <summary>
        /// Méthode qui fait avancer le serpent
        /// </summary>
        public void Avancer()
        {
            positioncorps.Add(positionTete);
            switch (direction)
            {
                // Haut
                case 0:
                    positionTete.Y -= 1;
                    break;
                 // Droite
                case 1:
                    positionTete.X += 1;
                    break;
                // Gauche
                case 2:
                    positionTete.X -= 1;
                    break;
                // Bas
                case 3:
                    positionTete.Y += 1;
                    break;
            }
            if (grandir > 0)
                grandir--;
            else
                positioncorps.RemoveAt(0);

            if (positionTete.Y < 0)
            {
                positionTete.Y = Cellule.Y - 1;
            }
            if (positionTete.Y > Cellule.Y - 1)
            {
                positionTete.Y = 0;
            }
            if (positionTete.X < 0)
            {
                positionTete.X = Cellule.X - 1 ;
            }
            if (positionTete.X > Cellule.X - 1 )
            {
                positionTete.X = 0;
            }
        }

        /// <summary>
        /// Méthode qui change la direction du serpent
        /// </summary>
        /// <param name="direction"></param>
        public void ChangerDirection(int direction)
        {
            this.direction = direction;
        }

        /// <summary>
        /// Méthode qui fait grandir le serpent
        /// </summary>
        /// <param name="grandir"></param>
        public void Grandir(int grandir)
        {
            this.grandir = grandir;
        }
        #endregion
    }
}
