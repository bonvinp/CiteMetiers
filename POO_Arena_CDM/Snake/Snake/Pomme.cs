/*************************************************
 * Auteur         : Guillaume Pin
 * Co-Auteur      : Kilian Périsset
 * Nom du fichier : Snake
 * Description    : Jeu du Snake digne du nokia 3310
 * Date           : 22 novembre 2017
 * Version        : 1.0
 * **************************************************/

using System;
using System.Drawing;
using System.Windows.Forms;

namespace Snake
{
    class Pomme
    {
        #region Champs
        public Point position = new Point();
        int marge;
        Point Cellule;
        Random rdn = new Random();
        #endregion

        #region Constructeur
        /// <summary>
        /// Constructeur de la class
        /// </summary>
        /// <param name="NombreCelluleX">Nombre de cellule sur l'axe X</param>
        /// <param name="NombreCelluleY">Nombre de cellule sur l'axe Y</param>
        /// <param name="marge">Marge du jeu</param>
        public Pomme(int NombreCelluleX, int NombreCelluleY, int marge)
        {
            position = new Point(rdn.Next(0, NombreCelluleX), rdn.Next(0, NombreCelluleY));
            Cellule = new Point(NombreCelluleX, NombreCelluleY);
            this.marge = marge;
        }
        #endregion

        #region Méthode
        /// <summary>
        /// Méthode qui dessine le bonus
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        public void Paint(object sender, PaintEventArgs e)
        {
            // Affiche le bonus
            e.Graphics.FillRectangle(new SolidBrush(Color.Red), marge + position.X * Cellule.X, marge + position.Y * Cellule.Y, Cellule.X, Cellule.Y);
        }
        #endregion  
    }
}
