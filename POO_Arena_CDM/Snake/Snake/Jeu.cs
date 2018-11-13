/*************************************************
 * Auteur         : Guillaume Pin
 * Co-Auteur      : Kilian Périsset, Dylan Schito, Robin Brunazzi
 * Nom du fichier : Snake
 * Description    : Jeu du Snake digne du nokia 3310
 * Date           : 13 novembre 2018
 * Version        : 2.0
 *************************************************/

using System;
using System.Drawing;
using System.Windows.Forms;

namespace Snake
{
    class Jeu
    {
        #region CONSTANTE
        const int MARGE = 10;
        #endregion

        #region Champs
        bool perdu;
        public Point position = new Point();
        Pomme bonus;
        Serpent sperpent;
        Form1 form;
        int score;
        Label lblScore;
        Timer time;

        public int Score { get => score; private set => score = value; }
        #endregion

        #region Constructeur
        /// <summary>
        /// Constructeur du jeu
        /// </summary>
        /// <param name="view"></param>
        /// <param name="h">Nombre de cellule en hauteur</param>
        /// <param name="l">Nombre de cellule de largueur</param>
        public Jeu(Form1 view, Label pLblScore, int h, int l)
        {
            // Recuper la position
            position = new Point(l, h);
            // Mets la variable sur false
            perdu = false;

            // Instancie le serpent et le premier bonus
            sperpent = new Serpent(l, h, MARGE);
            bonus = new Pomme(l, h, MARGE);

            // Parametrage du Timer
            time = new Timer();
            time.Interval = 300;
            time.Enabled = true;
            time.Start();
            time.Tick += new EventHandler(this.time_tick);
            // Parametrage de la form
            this.form = view;
            view.Paint += this.Paint;
            this.form.KeyPress += new KeyPressEventHandler(this.Form1_KeyPress);
            this.lblScore = pLblScore;
            this.Score = 0;
            lblScore.Text = $"Score : {this.Score}";
        }
        #endregion

        #region Méthode
        /// <summary>
        /// Méthode qui affiche le jeu
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        public void Paint(object sender, PaintEventArgs e)
        {
            // Pour tous les points dans la grille
            for (int y = 0; y < position.Y; y++)
                for (int x = 0; x < position.X; x++)
                    // Dessine de l'herbe dans la grille
                    e.Graphics.DrawImage(new Bitmap(Properties.Resources.monherbe), new Rectangle(MARGE + x * position.X, MARGE + y * position.Y, position.X, position.Y));
            if (bonus != null)
            {
                // Affiche le bonus
                bonus.Paint(sender, e);
            }
            // Affiche le serpent
            sperpent.Paint(sender, e);
        }

        /// <summary>
        /// Mets à jour l'affichage
        /// </summary>
        public void Update()
        {
            // Fait avancer le serpent
            sperpent.Avancer();
            if (bonus != null)
            {
                if (sperpent.positionTete == bonus.position)
                {
                    // Agrandit le serpent de 5
                    sperpent.Grandir(5);
                    if (time.Interval < 100)
                    {
                        time.Interval = 100;
                    }
                    // Diminue l'interval
                    time.Interval -= 50;
                    bonus = null;
                    Score += 1;
                    lblScore.Text = $"Score : {this.Score}";
                }
            }
            else
            {
                // Reaffiche un nouveau bonus
                bonus = new Pomme(position.X, position.Y, MARGE);
            }
        }

        /// <summary>
        /// Methode qui change la direction
        /// </summary>
        /// <param name="direction">Numéro de la direction</param>
        public void Pilotage(int direction)
        {
            sperpent.ChangerDirection(direction);
        }

        /// <summary>
        /// Méthode qui verifie si le joueur à perdu
        /// </summary>
        /// <returns>Vrai si le joueur à perdu</returns>
        public bool Perdu()
        {
            foreach (var item in sperpent.positioncorps)
            {

                if (item == sperpent.positionTete)
                {
                    perdu = true;
                }
            }
            return perdu;
        }

        /// <summary>
        /// Timer de la class
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="myEventArgs"></param>
        private void time_tick(Object sender, EventArgs myEventArgs)
        {
            Update();
            form.Invalidate();
            if (Perdu())
            {
                time.Stop();
                MessageBox.Show("Vous avez perdu !");
            }
        }

        /// <summary>
        /// Méthode qui récuper les touches entré par le joueur
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void Form1_KeyPress(object sender, KeyPressEventArgs e)
        {
            switch (e.KeyChar)
            {
                case 'w':
                    Pilotage(0);
                    break;
                case 's':
                    Pilotage(3);
                    break;
                case 'a':
                    Pilotage(2);
                    break;
                case 'd':
                    Pilotage(1);
                    break;
            }
        }
        #endregion
    }
}
