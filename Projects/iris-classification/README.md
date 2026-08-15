# Iris Dataset Classification with KNN

## Project Description

This project introduces the K-Nearest Neighbors (KNN) Machine Learning algorithm using the well-known Iris dataset.

The dataset contains measurements of iris flowers belonging to three different species:

* Iris Setosa
* Iris Versicolor
* Iris Virginica

For this project, the analysis focuses on two features:

* Petal length
* Petal width

The dataset contains 150 observations, with each observation associated with a class label:

* 0 → Iris Setosa
* 1 → Iris Versicolor
* 2 → Iris Virginica

## Machine Learning Algorithm

The K-Nearest Neighbors (KNN) algorithm is used for classification.

In this project:

Number of neighbors (k) = 3

The KNN model is implemented using the KNeighborsClassifier method from the Scikit-learn library.

from sklearn.neighbors import KNeighborsClassifier
model = KNeighborsClassifier(n_neighbors=3)

The model is then trained using the data and their corresponding labels.

model.fit(d, lab)

## Objective

The objective of this project is to understand the basic principles of a Machine Learning classification algorithm and apply KNN to classify Iris flowers based on their petal measurements.

## Technologies

* Python
* Scikit-learn
* K-Nearest Neighbors (KNN)
* Iris Dataset

## What I Learned

Through this project, I learned the basic workflow of a Machine Learning classification problem, including working with a dataset, selecting features, assigning labels, training a KNN model, and understanding the classification process.
